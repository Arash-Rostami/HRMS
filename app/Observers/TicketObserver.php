<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\NotifyUsersTicketAssigned;
use App\Notifications\NotifyUsersTicketCreated;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     *
     * @param \App\Models\Ticket $ticket
     * @return void
     */

    public function created(Ticket $ticket)
    {
        $psUsers = User::getActivePSDepartmentUsers();

        if ($psUsers->isEmpty()) {
            Log::channel('cache_operations')->info('No active PS department users found to notify.');
            return;
        }

        $primaryRecipient = $this->getManager($psUsers) ?? $this->getSupervisor($psUsers);

        if (!$primaryRecipient) {
            Log::channel('cache_operations')->info('No manager or supervisor found to notify.');
            return;
        }


        $notificationService = app(NotificationService::class);
        $ccRecipients = $this->getTeamMembers($psUsers, $primaryRecipient);
        $notification = new NotifyUsersTicketCreated($ticket, $ccRecipients);

        $notificationService->sendWithRetry($primaryRecipient, $notification, 'Ticket creation notification');
    }

    /**
     * Handle the Ticket "deleted" event.
     *
     * @param \App\Models\Ticket $ticket
     * @return void
     */
    public function deleted(Ticket $ticket)
    {
        $this->deleteRelatedFiles($ticket);
    }

    /**
     * Handle the Ticket "force deleted" event.
     *
     * @param \App\Models\Ticket $ticket
     * @return void
     */
    public function forceDeleted(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     *
     * @param \App\Models\Ticket $ticket
     * @return void
     */
    public function restored(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "updated" event.
     *
     * @param \App\Models\Ticket $ticket
     * @return void
     */
    public function updated(Ticket $ticket)
    {
        if ($ticket->wasChanged('assigned_to')) {


            $newAssignee = User::find($ticket->assigned_to);
            $requester = $ticket->requester;

            if ($newAssignee && $requester) {
                $notificationService = app(NotificationService::class);

                $notification = new NotifyUsersTicketAssigned($ticket, $requester->email);
                $notificationService->sendWithRetry($newAssignee, $notification, 'Ticket assignment notification');
            }
        }


        if ($ticket->wasChanged('status') && $ticket->status === 'closed') {
            $timeToCloseInSeconds = Carbon::parse($ticket->created_at)->diffInSeconds(Carbon::parse($ticket->updated_at));

            if (!$ticket->preventObserverUpdate) {
                $ticket->preventObserverUpdate = true;

                $this->unloopAndStore($ticket, $timeToCloseInSeconds);


                Log::channel('cache_operations')->info("Time to close the ticket calculated and saved in seconds: $timeToCloseInSeconds");
            }
        }

//        if ($ticket->wasChanged('status')) {
//            $requester = $ticket->requester;
//
//            if ($requester) {
//                $requester->notify(new NotifyUsersTicketStatusChanged($ticket));
//                Log::info("Status change notification sent to requester {$requester->email}.");
//            }
//        }

        $this->handleFileDeletion($ticket);
    }

    protected function deleteRelatedFiles(Ticket $ticket)
    {
        $requesterFiles = $ticket->requester_files ?? [];
        foreach ($this->extractFilePaths($requesterFiles) as $file) {
            if (File::exists(public_path($file))) {
                File::delete(public_path($file));
            }
        }

        $assigneeFiles = $ticket->assignee_files ?? [];
        foreach ($this->extractFilePaths($assigneeFiles) as $file) {
            if (File::exists(public_path($file))) {
                File::delete(public_path($file));
            }
        }
    }

    protected function extractFilePaths($files): array
    {
        return array_filter(array_map(function ($item) {
            return is_array($item) && isset($item['file']) ? $item['file'] : null;
        }, $files));
    }

    /**
     * @param mixed $oldFiles
     * @param array $newFiles
     * @return array
     */
    protected function extractFiles(mixed $oldFiles, array $newFiles): array
    {
        $oldFilePaths = array_map(function ($item) {
            return is_array($item) && isset($item['file']) ? $item['file'] : null;
        }, $oldFiles);

        $newFilePaths = array_map(function ($item) {
            return is_array($item) && isset($item['file']) ? $item['file'] : null;
        }, $newFiles);

        $oldFilePaths = array_filter($oldFilePaths);
        $newFilePaths = array_filter($newFilePaths);
        return array($oldFilePaths, $newFilePaths);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection|array $psUsers
     * @return mixed
     */
    protected function getManager(\Illuminate\Database\Eloquent\Collection|array $psUsers): mixed
    {
        return $psUsers->first(function ($user) {
            return $user->profile && $user->profile->position === 'manager';
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection|array $psUsers
     * @return mixed
     */
    protected function getSupervisor(\Illuminate\Database\Eloquent\Collection|array $psUsers): mixed
    {
        return $psUsers->first(function ($user) {
            return $user->profile && $user->profile->position === 'supervisor';
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection|array $psUsers
     * @param mixed $primaryRecipient
     * @return array
     */
    protected function getTeamMembers(\Illuminate\Database\Eloquent\Collection|array $psUsers, mixed $primaryRecipient): array
    {
        return $psUsers->filter(function ($user) use ($primaryRecipient) {
            return $user->id !== $primaryRecipient->id
                && ($user->email == 's.mohammadzadeh@persolco.com' || $user->email == 'f.kazemi@persolco.com');
        })->pluck('email')->toArray();
    }

    protected function handleFileDeletion(Ticket $ticket)
    {
        if ($ticket->isDirty('requester_files')) {
            $oldFiles = $ticket->getOriginal('requester_files') ?? [];
            $newFiles = (array)($ticket->requester_files ?? []);
            list($oldFilePaths, $newFilePaths) = $this->extractFiles($oldFiles, $newFiles);

            $deletedFiles = array_diff($oldFilePaths, $newFilePaths);
            foreach ($deletedFiles as $file) {
                if (File::exists(public_path($file))) {
                    File::delete(public_path($file));
                }

            }
        }

        if ($ticket->isDirty('assignee_files')) {
            $oldFiles = $ticket->getOriginal('assignee_files') ?? [];
            $newFiles = (array)($ticket->assignee_files ?? []);
            list($oldFilePaths, $newFilePaths) = $this->extractFiles($oldFiles, $newFiles);

            $deletedFiles = array_diff($oldFilePaths, $newFilePaths);
            foreach ($deletedFiles as $file) {
                if (File::exists(public_path($file))) {
                    File::delete(public_path($file));
                }
            }
        }
    }

    /**
     * @param Ticket $ticket
     * @param float|int $timeToCloseInSeconds
     * @return void
     */
    protected function unloopAndStore(Ticket $ticket, float|int $timeToCloseInSeconds): void
    {
        $dispatcher = Ticket::getEventDispatcher();

        Ticket::unsetEventDispatcher();

        $ticket->extra = array_merge($ticket->extra ?? [], ['timeToCloseInSeconds' => $timeToCloseInSeconds]);
        $ticket->save();

        Ticket::setEventDispatcher($dispatcher);
    }
}
