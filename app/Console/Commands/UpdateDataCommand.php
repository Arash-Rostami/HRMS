<?php

namespace App\Console\Commands;

use App\Events\UpdateLastSeen;
use App\Events\UserLoggedOut;
use App\Models\User;
use Illuminate\Console\Command;

class UpdateDataCommand extends Command
{
    protected $signature = 'data:update';

    protected $description = 'Update data automatically after one 20.00';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        try {
            $now = now();

// DEPRECATED
//            User::where('status', 'active')
//                ->chunkById(100, function ($users) use ($now) {
//                    foreach ($users as $user) {
//                        // Dispatch the  event to change the timing
//                        event(new UpdateLastSeen($user));
//                        // Dispatch the event to change the presence to onleave
//                        event(new UserLoggedOut($user));
//                    }
//                });

            // Simpler way for handling it with Cron Job
            User::where('status', 'active')
                ->update([
                    'last_seen' => $now,
                    'presence' => User::PRESENCE_ONLEAVE,
                ]);

            $this->info('Data updated successfully.');
        } catch (\Exception $e) {
            $this->error('An error occurred while updating data: ' . $e->getMessage());
        }
    }
}
