<?php

namespace App\Console\Commands;

use App\Models\Suggestion;
use App\Services\SuggestionNotification;
use Illuminate\Console\Command;

class SendSuggestionReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:suggestion-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to users about pending suggestions.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(SuggestionNotification $suggestionNotification)
    {
        $this->info('Sending suggestion reminders...');

        $suggestionsByStatus = Suggestion::where('abort', 'no')
            ->whereIn('stage', ['pending', 'team_remarks', 'dept_remarks', 'awaiting_decision'])
            ->with(['user.profile', 'reviews.user.profile'])
            ->get()
            ->groupBy('stage');


        foreach ($suggestionsByStatus as $status => $suggestions) {
            $this->info("Processing status: {$status}");

            if ($status === 'awaiting_decision') {
                $suggestionNotification->notifyCEOForAwaitingDecision($suggestions);
            } else {
                $suggestions->each(function ($suggestion) use ($suggestionNotification) {
                    $stats = $suggestionNotification->getSuggestionStatsData($suggestion);
                    $pendingReviewers = $stats['pending_reviewers'];
                    $suggester = $stats['suggester'];
                    $suggestionNotification->sendNotifications($pendingReviewers, $suggestion, $suggester);
                });
            }
        }
        $this->info('Suggestion reminders sent.');
    }
}
