<?php

namespace Tests\Feature\Crew;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class EndorsementFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh, WithFaker;

    /**
     * @test
     */
    public function endorsees_can_ask_endorsements_from_endorsers()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorsee      = factory(Crew::class)->create();
        $crewPosition  = factory(CrewPosition::class)->create(['crew_id' => $endorsee->id]);
        $endorserEmail = $this->faker->email;

        // when
        $response = $this
            ->actingAs($endorsee->user)
            ->postJson(
                route('endorsement.store', ['crewPosition' => $crewPosition]),
                ['endorser_email' => $endorserEmail]
            );

        // then
        $this->assertDatabaseHas('endorsements', [
            'crew_position_id' => $crewPosition->id,
            'endorser_email'   => $endorserEmail,
            'approved_at'      => null,
            'comment'          => null,
            'deleted'          => false,
        ]);
    }

    /**
     * @test
     */
    public function endorsers_can_accept_endorsement_request_from_endorsees()
    {
        // given
        // an endorsee

        // when
        // he asks endorsements

        // then
        // endorser is emailed
        $this->assert();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function an_endorsee_can_only_be_endorsed_by_a_crew_once()
    {
        // given
        // given a crew with a position
        // and is endorsed by another crew'
        $endorsement = factory(Endorsement::class)->create();
        $crew        = $endorsement->crew;
        $position    = $endorsement->position;

        // when
        // askes endorsement again from same crew
        $crew->askEndorsementFrom($endorsement->email, $postion);

        // then
        // respond with forbiden 403
    }

    /**
     * @test
     */
    public function endorsement_link_will_endorse_an_endorsee()
    {
        // given
        // a user

        // when
        // he gets a link to endorse an endorsee

        // then
        // endorsee will get an approved endorsement
        $this->assert();
    }

    /**
     * @test
     */
    public function endorsed_crew_are_ranked_based_on_how_many_endorsers_they_get()
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

        $endorsee1 = factory(Crew::class)->create();

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

}
