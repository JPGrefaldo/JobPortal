<?php

namespace Tests\Unit\Actions\Endorsement;

use App\Actions\Endorsement\CreateEndorsementScore;
use App\Models\CrewEndorsementScoreSweetener;
use App\Models\CrewPosition;
use App\Models\CrewPositionEndorsementScore;
use App\Models\Endorsement;
use App\Models\EndorsementEndorser;
use App\Models\EndorsementRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CreateEndorsementScoreTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var \App\Models\Position
     */
    public $position;

    /**
     * @var \App\Models\Crew
     */
    public $crew;

    /**
     * @var \App\Models\CrewPosition
     */
    public $crewPosition;

    /**
     * @var \App\Actions\Endorsement\CreateEndorsementScore
     */
    public $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->crew = $this->createCrew()->crew;
        $this->position = $this->getRandomPosition();
        $this->crewPosition = $this->createCrewPosition($this->crew);
        $this->service = app(CreateEndorsementScore::class);
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\CreateEndorsementScore::execute
     */
    public function random_mix_of_sweetened_and_not()
    {
        $totalEndorsements = 10;
        $endorsementCount = $this->generateEndorsements($totalEndorsements, rand(0, 1));
        $score = $this->calculateScore($endorsementCount, $totalEndorsements);

        $this->assertEquals(
            $score,
            $this->service->execute($this->crewPosition)
        );

        $this->assertDatabaseHas('crew_position_endorsement_scores', [
            'crew_position_id' => $this->crewPosition->id,
            'score'            => $score,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\CreateEndorsementScore::execute
     */
    public function sweetened()
    {
        $totalEndorsements = 4;
        $endorsementCount = $this->generateEndorsements($totalEndorsements, 1);

        $score = $this->calculateScore($endorsementCount, $totalEndorsements);

        $this->assertEquals(
            $score,
            $this->service->execute($this->crewPosition)
        );

        $this->assertDatabaseHas('crew_position_endorsement_scores', [
            'crew_position_id' => $this->crewPosition->id,
            'score'            => $score,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\CreateEndorsementScore::execute
     */
    public function non_sweetened()
    {
        $totalEndorsements = 4;
        $endorsementCount = $this->generateEndorsements($totalEndorsements, 0);

        $score = $this->calculateScore($endorsementCount, $totalEndorsements);

        $this->assertEquals(
            $score,
            $this->service->execute($this->crewPosition)
        );

        $this->assertDatabaseHas('crew_position_endorsement_scores', [
            'crew_position_id' => $this->crewPosition->id,
            'score'            => $score,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\CreateEndorsementScore::execute
     */
    public function not_endorsed_at_all()
    {
        $endorsementCount = 0;
        $totalEndorsements = 0;

        $this->assertEquals(
            $this->calculateScore($endorsementCount, $totalEndorsements),
            $this->service->execute($this->crewPosition)
        );

        $this->assertDatabaseHas('crew_position_endorsement_scores', [
            'crew_position_id' => $this->crewPosition->id,
            'score'            => 1,
        ]);
    }

    /**
     * @param Crew $crew
     */
    private function createEndorsement($crew)
    {
        $request = factory(EndorsementRequest::class)->create([
            'endorsement_endorser_id' => EndorsementEndorser::create([
                'user_id' => $crew->user_id,
            ]),
        ]);
        $endorsement = factory(Endorsement::class)->create([
            'endorsement_request_id' => $request->id,
            'crew_position_id'       => $this->crewPosition->id,
        ]);
        $score = factory(CrewPositionEndorsementScore::class)->create([
            'crew_position_id' => $crew->crewPositions()->first(),
        ]);
    }

    /**
     * @param $position
     * @param $total
     */
    private function createTotalEndorsements($position, $total)
    {
        for ($i = 1; $i <= $total; $i++) {
            $request = factory(EndorsementRequest::class)->create();
            $endorsement = factory(Endorsement::class)->create([
                'endorsement_request_id' => $request->id,
                'crew_position_id'       => $position->id,
            ]);
        }
    }

    /**
     * @param Crew $crew
     * @return \App\Models\CrewEndorsementScoreSweetener
     */
    private function createSweetener($crew)
    {
        $randomSweetener = [
            0 => 10,
            1 => 20,
            2 => 30,
            3 => 40,
            4 => 50,
        ];

        return CrewEndorsementScoreSweetener::create([
            'crew_id'   => $crew->id,
            'sweetener' => $randomSweetener[rand(0, 4)],
        ]);
    }

    /**
     * @param Crew $crew
     * @return mixed
     */
    private function createCrewPosition($crew)
    {
        return factory(CrewPosition::class)->create([
            'crew_id'     => $crew->id,
            'position_id' => $this->position,
        ]);
    }

    /**
     * @param int $endorsementCount
     * @param int $totalEndorsements
     * @return float|int
     */
    private function calculateScore(int $endorsementCount, int $totalEndorsements)
    {
        return ($endorsementCount + 1) / ($totalEndorsements + 1);
    }

    /**
     * @param int $totalEndorsements
     * @return int
     */
    private function generateEndorsements(int $totalEndorsements, $doSweetener): int
    {
        $endorsementCount = 0;
        $endorser = [];
        for ($i = 1; $i <= $totalEndorsements; $i++) {
            $endorser[$i] = $this->createCrew()->crew;
            $position = $this->createCrewPosition($endorser[$i]);
            $this->createEndorsement($endorser[$i]);

            if ($doSweetener == 1) {
                $sweetener = $this->createSweetener($endorser[$i]);
                $endorsementCount += $sweetener->sweetener;
            }

            $total = rand(5, 25);
            $this->createTotalEndorsements($position, $total);
            $endorsementCount += $total;
        }

        return $endorsementCount;
    }
}
