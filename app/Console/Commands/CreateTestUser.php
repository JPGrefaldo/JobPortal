<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\Site;
use App\Services\AuthServices;
use App\Services\UsersServices;
use Illuminate\Console\Command;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:test_user {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a test user';

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
        $user = app(UsersServices::class)->create([
            'first_name' => 'Test',
            'last_name'  => 'User',
            'email'      => $this->argument('email'),
            'password'   => 'test123',
            'phone'      => '555-555-5555',
        ]);
        $user->confirm();

        foreach ([Role::CREW, Role::PRODUCER] as $_ => $type) {
            app(AuthServices::class)->createByRoleName(
                $type,
                $user,
                Site::whereHostname('crewcalls.test')->first()
            );
        }

        $this->info('Created');
    }
}
