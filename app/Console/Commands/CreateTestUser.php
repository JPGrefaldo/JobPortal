<?php

namespace App\Console\Commands;

use App\Actions\Auth\AddUserToSite;
use App\Actions\Crew\StubCrew;
use App\Actions\User\CreateUser;
use App\Models\Role;
use App\Models\Site;
use App\Models\User;
use App\Utils\UrlUtils;
use Illuminate\Console\Command;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test_user {email} {role?}';

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
        $email = $this->argument('email');
        $role  = $this->argument('role');

        if (User::where('email', $email)->count()) {
            $this->error('Test user is already created');
            return;
        }

        if ($role == '' ||
            ($role != 'admin' && $role != 'crew' && $role != 'producer' && $role != 'all')
        ) {
            $this->error('Enter role type: admin | crew | producer');
            return;
        }

        $user = app(CreateUser::class)->execute([
            'first_name' => 'Test',
            'last_name'  => 'User',
            'nickname'   => 'The User',
            'email'      => $email,
            'password'   => 'test123',
            'phone'      => '555-555-5555',
        ]);

        if ($role == 'admin' || $role == 'all') {
            $user->assignRole(Role::ADMIN);
        }

        if ($role == 'crew' || $role == 'all') {
            $user->assignRole(Role::CREW);
            app(StubCrew::class)->execute($user);
        }

        if ($role == 'producer' || $role == 'all') {
            $user->assignRole(Role::PRODUCER);
        }

        app(AddUserToSite::class)->execute(
            $user,
            Site::whereHostname(
                UrlUtils::getHostNameFromBaseUrl(config('app.url'))
            )->first()
        );

        $user->confirm();

        $user->notificationSettings()->create([
            'receive_email_notification' => true,
            'receive_other_emails'       => true,
            'receive_sms'                => true,
        ]);

        $this->info('User with ' . $role . ' role created.');
    }
}
