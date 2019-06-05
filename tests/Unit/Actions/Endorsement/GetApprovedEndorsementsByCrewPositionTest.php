<?php

use App\Actions\Endorsement\GetApprovedEndorsementsByCrewPosition;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\EndorsementEndorser;
use App\Models\EndorsementRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class GetApprovedEndorsementsByCrewPositionTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var GetApprovedEndorsementsByCrewPosition
     */
    public $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(GetApprovedEndorsementsByCrewPosition::class);
    }

    /**
     * @test
     * @covers GetApprovedEndorsementsByCrewPosition::execute
     */
    public function exectue()
    {
        $testData = $this->createEndorsement(\Carbon\Carbon::now());

        $ret = $this->service->execute($testData['crew_position']);

        $this->assertEquals($testData['endorsement']->id, $ret->first()->id);
    }

    /**
     * @test
     * @covers GetApprovedEndorsementsByCrewPosition::execute
     */
    public function no_approved()
    {
        $testData = $this->createEndorsement();

        $ret = $this->service->execute($testData['crew_position']);

        $this->assertEquals(0, $ret->count());
    }

    /**
     * @return array
     */
    private function createEndorsement($approved_at = null): array
    {
        $endorser = factory(EndorsementEndorser::class)->create();

        $user = $this->createCrew();
        $crew = $user->crew;
        $position = $this->getRandomPosition();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id'     => $crew->id,
            'position_id' => $position,
        ]);
        $request = factory(EndorsementRequest::class)->create([
            'endorsement_endorser_id' => $endorser->id,
        ]);
        $endorsement = factory(Endorsement::class)->create([
            'endorsement_request_id' => $request->id,
            'crew_position_id'       => $crewPosition->id,
            'approved_at'            => $approved_at,
        ]);

        return [
            'user'          => $user,
            'position'      => $position,
            'crew_position' => $crewPosition,
            'request'       => $request,
            'endorsement'   => $endorsement,
        ];
    }
}
