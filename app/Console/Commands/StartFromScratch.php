<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class StartFromScratch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'startfromscratch {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate, seed, create test user';

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
        $bar = $this->output->createProgressBar(3);

        Artisan::call('migrate');
        $bar->advance();
        Artisan::call('db:seed');
        $bar->advance();
        Artisan::call('test_user', ['email' => $this->argument('email')]);

        $bar->finish();
    }
}
