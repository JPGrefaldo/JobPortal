<?php

namespace Tests\Feature;

use App\Models\CrewProject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class FakeMessengerDashboardTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;
    /**
     * @test
     * @covers \App\Console\Commands\FakeMessengerDashboard::handle
     */
    public function execute()
    {
        $user = $this->createCrew();

        $command = $this->artisan('fake:messenger_dashboard', [
        ]);

        $command
            ->expectsOutput('Seeding MessengerDashboardSeeder')
            ->expectsOutput('MessengerDashboard Seeded')
            ->run();

        $command->assertExitCode(0);

        $this->assertDatabaseHas('messages', [
            'user_id' => $user->id,
        ]);
    }
}
