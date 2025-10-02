<?php

namespace App\Services;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    private int $maxAttempts = 3;
    private array $delays = [0, 3, 6];

    public function sendWithRetry($user, Notification $notification, string $context = 'notification'): bool
    {
        for ($i = 0; $i < $this->maxAttempts; $i++) {
            try {
                if ($this->delays[$i] > 0) {
                    usleep($this->delays[$i] * 1000000);
                }

                $user->notify($notification);

                $attemptText = $i > 0 ? " (attempt " . ($i + 1) . ")" : "";
                Log::channel('cache_operations')->info("{$context} sent to {$user->email}{$attemptText}");

                return true;

            } catch (\Swift_TransportException $e) {
                if ($this->isTemporaryError($e->getMessage())) {
                    Log::channel('cache_operations')->warning("Temporary mail server issue for {$user->email}, attempt " . ($i + 1) . "/{$this->maxAttempts}");
                    continue;
                }
                $this->logFinalError($user->email, $context, $this->maxAttempts, $e->getMessage());
                return false;

            } catch (\Exception $e) {
                $errorMessage = substr($e->getMessage(), 0, 100);
                Log::channel('cache_operations')->warning("{$context} attempt " . ($i + 1) . " failed for {$user->email}: {$errorMessage}");

                if ($i === $this->maxAttempts - 1) {
                    $this->logFinalError($user->email, $context, $this->maxAttempts, $e->getMessage());
                    return false;
                }
            }
        }

        return false;
    }

    private function isTemporaryError(string $message): bool
    {
        return str_contains($message, '503') ||
            str_contains($message, 'Temporary') ||
            str_contains($message, 'temporary');
    }

    private function logFinalError(string $email, string $context, int $attempts, string $error): void
    {
        Log::channel('cache_operations')->error("{$context} delivery failed for {$email} after {$attempts} attempts. Operation continues without notification. Error: " . substr($error, 0, 200));
    }
}
