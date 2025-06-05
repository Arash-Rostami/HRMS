<?php

namespace App\Console\Commands;


use App\Services\api\OffsiteUsers;
use App\Services\api\OnsiteUsers;
use App\Services\ETSClient;
use Illuminate\Console\Command;

class UpdateAttendanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:attendance';

    protected $description = 'Attendance is automatically updated a few times every hour';

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
            (new ETSClient())->updateAttendance();
            $this->info('Attendance updated successfully.');
        } catch (\Exception $e) {
            $this->error('An error occurred while updating attendance: ' . $e->getMessage());
        }
    }
}
