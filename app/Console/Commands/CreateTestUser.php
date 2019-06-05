<?php

namespace App\Console\Commands;

use App\Actions\Auth\AddUserToSite;
use App\Actions\Crew\StubCrew;
use App\Models\Role;
use App\Models\Site;
use App\Models\User;
use App\Utils\UrlUtils;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test_user {email}
                            {--a|admin : Create test user with Admin role}
                            {--c|crew : Create test user with Crew role}
                            {--p|producer : Create test user with Producer role}';

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
     * @throws Exception
     */
    public function handle()
    {
        $email = $this->argument('email');
        $role = $this->options();

        $roles = ['admin', 'crew', 'producer'];

        if (User::where('email', $email)->count()) {
            $this->error('Test user is already created');
            return;
        }

        if (! ($role['admin'] || $role['crew'] || $role['producer'])) {
            $this->error('Enter role type: admin | crew | producer');
            return;
        }

        $user = factory(User::class)->create([
            'email'    => $email,
            'password' => Hash::make('test123'),
            'phone'    => '555-555-5555',
        ]);

        foreach ($roles as $index) {
            if ($role[($index)]) {
                $user->assignRole(constant(Role::class . '::' . strtoupper($index)));
            }

            if ($index == 'crew') {
                app(StubCrew::class)->execute($user);
            }
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

        $this->info('User with role created.');
    }
}
