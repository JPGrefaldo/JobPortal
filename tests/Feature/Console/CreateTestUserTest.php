<?php

namespace Tests\Feature\Console;

use App\Models\Role;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CreateTestUserTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;

    const CMD = 'test_user';
    const HOST_NAME = 'test-crewcalls.dev';

    public function setUp()
    {
        parent::setUp();

        config([
            'app.name' => 'Crewcalls Test',
            'app.url'  => 'http://' . self::HOST_NAME,
        ]);
        factory(Site::class)->create([
            'name'     => 'Crewcalls Test',
            'hostname' => self::HOST_NAME,
        ]);
    }

    /**
     * @test
     * @covers \App\Console\Commands\CreateTestUser::handle
     */
    public function execute()
    {
        $command = $this->artisan(self::CMD, [
            'email' => 'test@test.com',
        ]);

        $command->expectsOutput('Created')
            ->run();

        $user = User::where('email', 'test@test.com')
            ->whereHas('sites', function ($query) {
                $query->where('hostname', self::HOST_NAME);
            })->first();

        $user->load('roles', 'notificationSettings');

        $this->assertArrayHas([
            'confirmed'             => true,
            'notification_settings' => [
                'receive_email_notification' => true,
                'receive_other_emails'       => true,
                'receive_sms'                => true,
            ],
        ], $user->toArray());

        $this->assertTrue($user->hasAllRoles([Role::PRODUCER, Role::CREW]));

        $command->assertExitCode(0);
    }

    /**
     * @test
     * @covers \App\Console\Commands\CreateTestUser::handle
     */
    public function error_on_created()
    {
        $this->createUser([
            'email' => 'test@test.com',
        ]);

        $command = $this->artisan(self::CMD, [
            'email' => 'test@test.com',
        ]);

        $command->expectsOutput('Test user is already created')
            ->run();

        $command->assertExitCode(1);
    }
}
