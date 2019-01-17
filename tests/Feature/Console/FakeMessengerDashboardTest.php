<?php

namespace Tests\Feature;

use Tests\TestCase;

class FakeMessengerDashboardTest extends TestCase
{
    /**
     * @test
     * @covers \App\Console\Commands\FkaeMessengerDashboardTest
     */
    public function execute()
    {
        // given
        $command = $this->artisan('startfromscratch', [
            'email' => 'admin@admin.com'
        ]);


        // when
        $command = $this->artisan('fake:messenger_dashboard', [
        ]);

        // then
        $command
            ->expectsOutput('Seeding MessengerDashboardSeeder')
            ->expectsOutput('MessengerDashboard Seeded')
            ->run();

        $command->assertExitCode(0);
    }
}
