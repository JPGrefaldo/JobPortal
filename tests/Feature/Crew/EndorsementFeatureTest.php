<?php

namespace Tests\Feature\Crew;

use Tests\TestCase;
use App\Models\Crew;
use App\Models\Position;
use App\Models\Endorsement;
use App\Models\CrewPosition;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EndorsementFeatureTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('db:seed', ['--class' => 'LocalDatabaseSeeder']);
    }

    /**
     * @test
     */
    public function it_lists_endorsements_sorted_by_number_of_endorsements()
    {
        $this->withoutExceptionHandling();
        // given
        $endorsement = factory(Endorsement::class)->create();

        $endorsee = $endorsement->crew;
        $endorser = factory(Crew::class)->create();
        $position = $endorsement->crewPosition->position;
        $endorsee->askEndorsementFrom($endorser->email, $position);




        // given
        // users that have asked endorsements
        // endorsee 1 asks 1 endorsement
        $position = factory(Position::class)->create();

        $endorser1 = factory(Crew::class)->create();

        $endorsee1    = factory(Crew::class)->create();

        $endorsement1 = $endorsee1->askEndorsementFrom($endorser1->user->email, $position);

        $endorser1->acceptEndorsement($endorsement1);

        // endorsee 2 asks 2 endorsements
        $endorser2 = factory(Crew::class)->create();
        $endorser3 = factory(Crew::class)->create();

        $endorsee2    = factory(Crew::class)->create();
        $endorsement2 = $endorsee2->askEndorsementFrom($endorser2->user->email, $position);
        $endorsement3 = $endorsee2->askEndorsementFrom($endorser3->user->email, $position);

        $endorser2->acceptEndorsement($endorsement1);
        $endorser3->acceptEndorsement($endorsement1);

        // endorsee 3 asks 3 endorsements
        $endorser4 = factory(Crew::class)->create();
        $endorser5 = factory(Crew::class)->create();
        $endorser6 = factory(Crew::class)->create();

        $endorsee3    = factory(Crew::class)->create();
        $endorsement4 = $endorsee3->askEndorsementFrom($endorser4->user->email, $position);
        $endorsement5 = $endorsee3->askEndorsementFrom($endorser5->user->email, $position);
        $endorsement6 = $endorsee3->askEndorsementFrom($endorser6->user->email, $position);

        $endorser4->acceptEndorsement($endorsement4);
        $endorser5->acceptEndorsement($endorsement5);
        $endorser6->acceptEndorsement($endorsement6);
        // and those endorsements are approved

        // when
        // I visit index page of a position I must see endorsements sorted by most voted to least voted
        $response = $this->getJson("/positions/{$position->id}/endorsements");

        dd(collect(json_decode($response->getContent()))->pluck('id'));

        // then
        $this->assertEquals($endorsements->ids, $project->topEndorsees);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function an_endorsee_can_only_be_endorsed_by_a_crew_once()
    {
        // given
        $endorsement = factory(Endorsement::class)->create();
        $crew = $endorsement->crew;
        $position = $endorsement->position;


        // when
        $crew->askEndorsementFrom($endorsement->email, $postion);


        // then
    }
}
