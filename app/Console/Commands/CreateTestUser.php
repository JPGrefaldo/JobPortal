<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\Site;
use App\Services\AuthServices;
use App\Services\User\UsersServices;
use Illuminate\Console\Command;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test_user {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a test user (requires email address)';

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
     * @throws \Exception
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

        foreach ([Role::CREW, Role::PRODUCER] as $_ => $type) {
            app(AuthServices::class)->createByRoleName(
                $type,
                $user,
                Site::whereHostname('crewcalls.test')->first()
            );
        }

        $user->confirm();

        $user->notificationSettings()->create([
            'receive_email_notification' => true,
            'receive_other_emails' => true,
            'receive_sms' => true,
        ]);

        $this->info('Created');
    }
}
