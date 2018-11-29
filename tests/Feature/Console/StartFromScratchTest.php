<?php

namespace Tests\Feature\Console;

use App\Models\Site;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StartFromScratchTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;

    const CMD = 'startfromscratch';

    public function setUp()
    {
        parent::setUp();

        config([
            'app.name' => 'Crewcalls Test',
            'app.url'  => 'http://crewcalls.test',
        ]);
        factory(Site::class)->create([
            'name'     => 'Crewcalls Test',
            'hostname' => 'crewcalls.test',
        ]);
    }

    /** @test */
    public function execute()
    {
        $command = $this->artisan(self::CMD, [
            'email' => 'test@test.com',
        ]);

        $command->expectsOutput('Start Migrations')
            ->expectsOutput('Migrations Completed')
            ->expectsOutput('Start DB Seeds')
            ->expectsOutput('DB Seeded')
            ->expectsOutput('Creating User')
            ->expectsOutput('User Created')
            ->run();
        $command->assertExitCode(0);
    }
}
