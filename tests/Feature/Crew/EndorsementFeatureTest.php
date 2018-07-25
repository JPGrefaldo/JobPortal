<?php

namespace Tests\Feature\Crew;

use App\EndorsementRequest;
use App\Mail\EndorsementRequestEmail;
use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
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
        $endorsee     = factory(Crew::class)->states('withRole')->create();
        $user         = $endorsee->user;
        $position     = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id'     => $endorsee->id,
            'position_id' => $position->id,
        ]);

        $endorserName1  = $this->faker->name;
        $endorserEmail1 = $this->faker->email;

        $endorserName2  = $this->faker->name;
        $endorserEmail2 = $this->faker->email;

        // when
        $response = $this
            ->actingAs($user)
            ->postJson(
                route('endorsement-request.store', ['crewPosition' => $crewPosition->id]),
                [
                    'endorsers' => [
                        [
                            'name'  => $endorserName1,
                            'email' => $endorserEmail1,
                        ],
                        [
                            'name'  => $endorserName2,
                            'email' => $endorserEmail2,
                        ],
                    ],
                ]
            );

        $endorsementRequest = EndorsementRequest::first();

        // then
        $this->assertDatabaseHas('endorsement_requests', [
            'crew_position_id' => $crewPosition->id,
        ]);

        $this->assertDatabaseHas('endorsements', [
            'endorsement_request_id' => $endorsementRequest->id,
            'endorser_name'          => $endorserName1,
            'endorser_email'         => $endorserEmail1,
        ]);

        $this->assertDatabaseHas('endorsements', [
            'endorsement_request_id' => $endorsementRequest->id,
            'endorser_name'          => $endorserName2,
            'endorser_email'         => $endorserEmail2,
        ]);
    }

    /**
     * @test
     */
    public function endorsement_request_email_is_sent_to_endorsers_after_endorsees_ask_for_an_endorsement()
    {
        // $this->withoutExceptionHandling();
        Mail::fake();

        // given
        $endorsee     = factory(Crew::class)->states('withRole')->create();
        $user         = $endorsee->user;
        $position     = factory(Position::class)->create(['name' => 'Makeup']);
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id'     => $endorsee->id,
            'position_id' => $position->id,
        ]);

        $endorserName1  = $this->faker->name;
        $endorserEmail1 = $this->faker->email;

        $endorserName2  = $this->faker->name;
        $endorserEmail2 = $this->faker->email;

        // when
        $response = $this
            ->actingAs($user)
            ->postJson(
                route('endorsement-request.store', ['crewPosition' => $crewPosition->id]),
                [
                    'endorsers' => [
                        [
                            'name'  => $endorserName1,
                            'email' => $endorserEmail1,
                        ],
                        [
                            'name'  => $endorserName2,
                            'email' => $endorserEmail2,
                        ],
                    ],
                ]
            );

        // then
        Mail::assertSent(EndorsementRequestEmail::class, 2);
    }

    /**
     * @test
     */
    public function endorser_can_approve_an_endorsement()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorsementRequest = factory(EndorsementRequest::class)->create();
        $endorser1          = factory(Crew::class)->states('withRole')->create();
        $endorser2          = factory(Crew::class)->states('withRole')->create();

        // when
        $response1 = $this
            ->actingAs($endorser1->user)
            ->postJson(route('endorsement.store', ['endorsementRequest' => $endorsementRequest]), [
                'comment' => $this->faker->sentence,
            ]);

        $response2 = $this
            ->actingAs($endorser2->user)
            ->postJson(route('endorsement.store', ['endorsementRequest' => $endorsementRequest]), [
                'comment' => '',
            ]);

        // then
        $this->assertCount(2, Endorsement::all()->toArray());
    }

    /**
     * @test
     */
    public function an_endorsee_can_only_ask_to_be_endorsed_by_the_same_crew_once()
    {
        // $this->withoutExceptionHandling();
        Mail::fake();
        // given
        // given an endorsee
        $endorsee     = factory(Crew::class)->states('withRole')->create();
        $user         = $endorsee->user;
        $position     = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id'     => $endorsee->id,
            'position_id' => $position->id,
        ]);

        $endorserName1  = $this->faker->name;
        $endorserEmail1 = $this->faker->email;

        $endorserName2  = $this->faker->name;
        $endorserEmail2 = $this->faker->email;

        $response = $this
            ->actingAs($user)
            ->postJson(
                route('endorsement-request.store', ['crewPosition' => $crewPosition->id]),
                [
                    'endorsers' => [
                        [
                            'name'  => $endorserName1,
                            'email' => $endorserEmail1,
                        ],
                        [
                            'name'  => $endorserName2,
                            'email' => $endorserEmail2,
                        ],
                    ],
                ]
            );

        // when
        // endorsee asks for endorsement again
        $response = $this
            ->actingAs($user)
            ->postJson(
                route('endorsement-request.store', ['crewPosition' => $crewPosition->id]),
                [
                    'endorsers' => [
                        [
                            'name'  => $endorserName1,
                            'email' => $endorserEmail1,
                        ],
                        [
                            'name'  => $endorserName2,
                            'email' => $endorserEmail2,
                        ],
                    ],
                ]
            );

        // then
        Mail::assertSent(EndorsementRequestEmail::class, 2);
        $this->assertCount(2, Endorsement::all()->toArray());
    }

    /**
     * @test
     */
    public function an_endorser_can_only_approve_an_endorsement_by_the_same_crew_once()
    {
        // $this->withoutExceptionHandling();
        // given
        // an endorsement request
        $endorsementRequest = factory(EndorsementRequest::class)->create();
        // endorser endorses an endorsement of the same crew
        $endorser = factory(Crew::class)->states('withRole')->create();

        $response = $this
            ->actingAs($endorser->user)
            ->postJson(route('endorsement.store', ['endorsementRequest' => $endorsementRequest]), [
                'comment' => $this->faker->sentence,
            ]);

        // when
        // endorser endorses the same crew again
        $response = $this
            ->actingAs($endorser->user)
            ->postJson(route('endorsement.store', ['endorsementRequest' => $endorsementRequest]), [
                'comment' => $this->faker->sentence,
            ]);

        // then
        // endorser is forbidden
        $this->assertCount(1, Endorsement::all()->toArray());
    }

    /**
     * @test
     */
    public function endorsed_crew_are_ranked_based_on_how_many_endorsers_they_get()
    {
        // $this->withoutExceptionHandling();
        // // given
        // $endorsement = factory(Endorsement::class)->create();

        // $endorsee = $endorsement->crew;
        // $endorser = factory(Crew::class)->create();
        // $position = $endorsement->crewPosition->position;
        // $endorsee->askEndorsementFrom($endorser->email, $position);

        // // given
        // // users that have asked endorsements
        // // endorsee 1 asks 1 endorsement
        // $position = factory(Position::class)->create();

        // $endorser1 = factory(Crew::class)->create();

        // $endorsee1 = factory(Crew::class)->create();

        // $endorsement1 = $endorsee1->askEndorsementFrom($endorser1->user->email, $position);

        // $endorser1->acceptEndorsement($endorsement1);

        // // endorsee 2 asks 2 endorsements
        // $endorser2 = factory(Crew::class)->create();
        // $endorser3 = factory(Crew::class)->create();

        // $endorsee2    = factory(Crew::class)->create();
        // $endorsement2 = $endorsee2->askEndorsementFrom($endorser2->user->email, $position);
        // $endorsement3 = $endorsee2->askEndorsementFrom($endorser3->user->email, $position);

        // $endorser2->acceptEndorsement($endorsement1);
        // $endorser3->acceptEndorsement($endorsement1);

        // // endorsee 3 asks 3 endorsements
        // $endorser4 = factory(Crew::class)->create();
        // $endorser5 = factory(Crew::class)->create();
        // $endorser6 = factory(Crew::class)->create();

        // $endorsee3    = factory(Crew::class)->create();
        // $endorsement4 = $endorsee3->askEndorsementFrom($endorser4->user->email, $position);
        // $endorsement5 = $endorsee3->askEndorsementFrom($endorser5->user->email, $position);
        // $endorsement6 = $endorsee3->askEndorsementFrom($endorser6->user->email, $position);

        // $endorser4->acceptEndorsement($endorsement4);
        // $endorser5->acceptEndorsement($endorsement5);
        // $endorser6->acceptEndorsement($endorsement6);
        // // and those endorsements are approved

        // // when
        // // I visit index page of a position I must see endorsements sorted by most voted to least voted
        // $response = $this->getJson("/positions/{$position->id}/endorsements");

        // // dd(collect(json_decode($response->getContent()))->pluck('id'));

        // // then
        // $this->assertEquals($endorsements->ids, $project->topEndorsees);
    }

}
