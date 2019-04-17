<?php

namespace Tests\Unit\Actions\Endorsement;

use App\Actions\Endorsement\GetEndorsements;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\EndorsementEndorser;
use App\Models\EndorsementRequest;
use App\Models\Position;
use App\Utils\StrUtils;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class GetEndorsementsTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var GetEndorsements
     */
    private $service;


    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(GetEndorsements::class);
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\GetEndorsements::execute
     */
    public function execute()
    {
        list($user, $position) = $this->createEndorsement(Carbon::now());

        $endorsements = $this->service->execute($user, $position, true);

        $this->assertEquals(1, $endorsements->count());
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\GetEndorsements::execute
     */
    public function execute_no_approved()
    {
        list($user, $position) = $this->createEndorsement();

        $endorsements = $this->service->execute($user, $position, true);

        $this->assertEquals(0, $endorsements->count());
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\GetEndorsements::execute
     */
    public function execute_get_not_approved()
    {
        list($user, $position) = $this->createEndorsement();

        $endorsements = $this->service->execute($user, $position);

        $this->assertEquals(1, $endorsements->count());
    }

    /**
     * @return array
     */
    private function createEndorsement($approved_at = null): array
    {
        $endorser = factory(EndorsementEndorser::class)->create();

        $user = $this->createCrew();
        $crew = $user->crew;
        $position = Position::inRandomOrder()->get()->first();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id'     => $crew->id,
            'position_id' => $position,
        ]);
        $request = EndorsementRequest::create([
            'endorsement_endorser_id' => $endorser->id,
            'token'                   => StrUtils::createRandomString(),
            'message'                 => 'test',
        ]);
        $endorsement = Endorsement::create([
            'endorsement_request_id' => $request->id,
            'crew_position_id'       => $crewPosition->id,
            'approved_at'            => $approved_at,
        ]);

        return [
            $user,
            $position,
            $request,
        ];
    }
}
