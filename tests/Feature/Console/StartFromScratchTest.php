<?php

namespace Tests\Feature\Console;

use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class StartFromScratchTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;

    const CMD = 'startfromscratch';
    const HOST_NAME = 'test-crewcalls.dev';

    public function setUp(): void
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
     * @covers \App\Console\Commands\StartFromScratch::handle
     */
    public function execute()
    {
        $email = 'test@test.com';
        $command = $this->artisan(self::CMD, [
            'email' => $email,
        ]);

        $command->expectsOutput('Start Migrations')
            ->expectsOutput('Migrations Completed')
            ->expectsOutput('Start DB Seeds')
            ->expectsOutput('DB Seeded')
            ->expectsOutput('Creating User')
            ->expectsOutput('User Created')
            ->run();

        $command->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);
    }
}
