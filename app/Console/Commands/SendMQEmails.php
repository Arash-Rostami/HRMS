<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SendMQEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:monthly-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is to send the CEO\'s monthly question emails.';

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
     */
    public function handle()
    {
        $this->info('Starting queue worker...');

        Artisan::call('queue:work --stop-when-empty');

        $this->info('Queue worker completed.');
    }
}
