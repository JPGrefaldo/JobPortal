<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FakeMessengerDashboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:messenger_dashboard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds projects that have threads that have messages for both crew and producer roles.';

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
        $this->info('Seeding MessengerDashboardSeeder');
        Artisan::call('db:seed', ['--class' => 'MessengerDashboardSeeder']);
        $this->info('MessengerDashboard Seeded');
    }
}
