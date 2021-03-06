<?php

namespace Tests\Feature;

use App\Models\Endorsement;
use App\Models\EndorsementEndorser;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class FakeApprovedEndorsementsTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Console\Commands\FakeApprovedEndorsements::handle
     */
    public function execute()
    {
        $user = $this->createCrew();

        $command = $this->artisan('fake:endorsements', [
            'user' => $user->id,
        ]);

        $this->assertEquals(0, Endorsement::whereNotNull('approved_at')->count());

        $command->run();

        $command->assertExitCode(0);
        $this->assertEquals(5, Endorsement::whereNotNull('approved_at')->count());
        $this->assertEquals(5, EndorsementEndorser::count());
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeApprovedEndorsements::handle
     */
    public function execute_with_number()
    {
        $user = $this->createCrew();

        $command = $this->artisan('fake:endorsements', [
            'user'   => $user->id,
            'number' => 2,
        ]);

        $command->run();

        $command->assertExitCode(0);
        $this->assertEquals(2, Endorsement::whereNotNull('approved_at')->count());
        $this->assertEquals(2, EndorsementEndorser::count());
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeApprovedEndorsements::handle
     */
    public function execute_with_position()
    {
        $user = $this->createCrew();

        $number = rand(1, Position::count());
        $position = Position::findOrFail($number);

        $this->assertDatabaseMissing('crew_position', [
            'position_id' => $position->id,
        ]);

        $command = $this->artisan('fake:endorsements', [
            'user'     => $user->id,
            'position' => $number,
        ]);

        $command->run();

        $command->assertExitCode(0);

        $this->assertEquals(5, Endorsement::whereNotNull('approved_at')->count());
        $this->assertEquals(5, EndorsementEndorser::count());
        $this->assertDatabaseHas('crew_position', [
            'position_id' => $position->id,
        ]);
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeApprovedEndorsements::handle
     * @expectedException \Exception
     */
    public function execute_with_create_position_off()
    {
        $user = $this->createCrew();

        $number = rand(1, Position::count());

        $command = $this->artisan('fake:endorsements', [
            'user'            => $user->id,
            'create_position' => 0,
            'position'        => $number,
        ]);

        $command->run();
    }
}
