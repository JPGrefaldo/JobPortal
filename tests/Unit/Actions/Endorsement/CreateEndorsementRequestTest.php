<?php

namespace Tests\Unit\Actions\Endorsement;

use App\Actions\Endorsement\CreateEndorsementRequest;
use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\EndorsementEndorser;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CreateEndorsementRequestTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var CreateEndorsementRequest
     */
    public $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(CreateEndorsementRequest::class);
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\CreateEndorsementRequest::execute
     */
    public function execute_with_non_user_endorser()
    {
        $user = $this->createCrew();
        $crew = factory(Crew::class)->create([
            'user_id' => $user->id,
        ]);
        $position = Position::inRandomOrder()->get()->first();

        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id'     => $crew->id,
            'position_id' => $position,
        ]);

        $email = 'test@test.com';
        $message = 'Endorse me please!';

        $endorsement = $this->service->execute($user, $position, $email, $message);

        $this->assertDatabaseHas('endorsement_endorsers', [
            'user_id' => null,
            'email'   => $email,
        ]);

        $this->assertDatabaseHas('endorsement_requests', [
            'message' => $message,
        ]);

        $this->assertEquals($crewPosition->id, $endorsement->crew_position_id);
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\CreateEndorsementRequest::execute
     */
    public function execute_with_user_endorser()
    {
        $endorser = $this->createCrew();

        $user = $this->createCrew();
        $crew = factory(Crew::class)->create([
            'user_id' => $user->id,
        ]);
        $position = Position::inRandomOrder()->get()->first();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id'     => $crew->id,
            'position_id' => $position,
        ]);

        $message = 'Endorse me please!';

        $endorsement = $this->service->execute($user, $position, $endorser->email, $message);

        $this->assertDatabaseHas('endorsement_endorsers', [
            'user_id' => $endorser->id,
            'email'   => null,
        ]);

        $this->assertDatabaseHas('endorsement_requests', [
            'message' => $message,
        ]);

        $this->assertEquals($crewPosition->id, $endorsement->crew_position_id);
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\CreateEndorsementRequest::execute
     */
    public function execute_with_multiple_same_email_endorser()
    {
        $user = $this->createCrew();
        $crew = factory(Crew::class)->create([
            'user_id' => $user->id,
        ]);
        $position = Position::inRandomOrder()->get()->first();

        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id'     => $crew->id,
            'position_id' => $position,
        ]);

        $email = 'test@test.com';
        $message = 'Endorse me please!';

        $endorsement = $this->service->execute($user, $position, $email, $message);
        $endorsement2 = $this->service->execute($user, $position, $email, $message);
        $endorsement3 = $this->service->execute($user, $position, $email, $message);

        $this->assertDatabaseHas('endorsement_endorsers', [
            'user_id' => null,
            'email'   => $email,
        ]);

        $this->assertEquals(1, EndorsementEndorser::whereEmail($email)->get()->count());
    }
}
