<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FakeFlaggedMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:flagged_messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds fake flaged messages';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('Seeding PendingFlaggedMessagesSeeder');
        Artisan::call('test_user admin@admin.com --admin');
        Artisan::call('db:seed', ['--class' => 'PendingFlaggedMessagesSeeder']);
        $this->info('PendingFlaggedMessagesSeeder Seeded');
    }
}
