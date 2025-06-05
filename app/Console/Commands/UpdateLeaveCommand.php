<?php

namespace App\Console\Commands;

use App\Services\ETSClient;
use Illuminate\Console\Command;

class UpdateLeaveCommand extends Command
{


    protected $signature = 'data:leave';

    protected $description = 'Leave is automatically updated every day';

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
    public function handle()
    {
        try {
            (new ETSClient())->updateLeave();
            $this->info('Leaves recorded successfully.');
        } catch (\Exception $e) {
            $this->error('An error occurred while persisting Leaves: ' . $e->getMessage());
        }
    }
}
