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
            $users = User::all();
            foreach ($users as $user) {
                // Dispatch the  event to change the timing
                event(new UpdateLastSeen($user));

                // Dispatch the event to change the presence to onleave
                event(new UserLoggedOut($user));
            }
            $this->info('Data updated successfully.');
        } catch (\Exception $e) {
            $this->error('An error occurred while updating data: ' . $e->getMessage());
        }
    }
}
