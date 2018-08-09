<?php

namespace Tests\Feature;

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

class EndorsementRequestFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh, WithFaker;

    /** CREATE */
    // this is defered to crew/position/show

    /** STORE */
    // authorization
    // validation

    /**
     * @test
     */
    public function endorsee_can_only_ask_endorsement_for_applied_positions()
    {
        // given
        $endorsee = factory(Crew::class)->states('withRole')->create();
        $nonAppliedPosition = factory(Position::class)->create();

        // when
        $response = $this->actingAs($endorsee->user)->post(route('endorsement_requests.store', $nonAppliedPosition));

        // then
        $response->assertForbidden();
    }

    // general logic
    /**
     * @test
     */
    public function endorsees_can_ask_endorsements_from_endorsers()
    {
        Mail::fake();

        // $this->withoutExceptionHandling();
        // given
        $endorsee = factory(Crew::class)->states('withRole')->create();
        $user = $endorsee->user;
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $endorsee->id,
            'position_id' => $position->id,
        ]);

        $endorserName1 = $this->faker->name;
        $endorserEmail1 = $this->faker->email;

        $endorserName2 = $this->faker->name;
        $endorserEmail2 = $this->faker->email;

        // when
        $response = $this
            ->actingAs($user)
            ->postJson(
                route('endorsement_requests.store', ['position' => $position->id]),
                [
                    'endorsers' => [
                        [
                            'name' => $endorserName1,
                            'email' => $endorserEmail1,
                        ],
                        [
                            'name' => $endorserName2,
                            'email' => $endorserEmail2,
                        ],
                    ],
                ]
            );

        $endorsementRequest = EndorsementRequest::first();

        // then
        $this->assertCount(2, Endorsement::all()->toArray());

        $this->assertDatabaseHas('endorsement_requests', [
            'crew_position_id' => $crewPosition->id,
        ]);

        $this->assertDatabaseHas('endorsements', [
            'endorsement_request_id' => $endorsementRequest->id,
            'endorser_name' => $endorserName1,
            'endorser_email' => $endorserEmail1,
        ]);

        $this->assertDatabaseHas('endorsements', [
            'endorsement_request_id' => $endorsementRequest->id,
            'endorser_name' => $endorserName2,
            'endorser_email' => $endorserEmail2,
        ]);

        Mail::assertSent(EndorsementRequestEmail::class, function ($mail) use ($endorsementRequest) {
            return $mail->endorsement->endorsement_request_id === $endorsementRequest->id;
        });
    }

    /**
     * @test
     */
    public function endorsement_request_email_is_sent_to_endorsers_after_endorsees_ask_for_an_endorsement()
    {
        // $this->withoutExceptionHandling();
        Mail::fake();

        // given
        $endorsee = factory(Crew::class)->states('withRole')->create();
        $user = $endorsee->user;
        $position = factory(Position::class)->create(['name' => 'Makeup']);
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $endorsee->id,
            'position_id' => $position->id,
        ]);

        $endorserName1 = $this->faker->name;
        $endorserEmail1 = $this->faker->email;

        $endorserName2 = $this->faker->name;
        $endorserEmail2 = $this->faker->email;

        // when
        $response = $this
            ->actingAs($user)
            ->postJson(
                route('endorsement_requests.store', ['position' => $position->id]),
                [
                    'endorsers' => [
                        [
                            'name' => $endorserName1,
                            'email' => $endorserEmail1,
                        ],
                        [
                            'name' => $endorserName2,
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
    public function an_endorsee_can_only_ask_to_be_endorsed_by_the_same_crew_once()
    {
        // $this->withoutExceptionHandling();
        Mail::fake();
        // given
        // given an endorsee
        $endorsee = factory(Crew::class)->states('withRole')->create();
        $user = $endorsee->user;
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $endorsee->id,
            'position_id' => $position->id,
        ]);

        $endorserName1 = $this->faker->name;
        $endorserEmail1 = $this->faker->email;

        $endorserName2 = $this->faker->name;
        $endorserEmail2 = $this->faker->email;

        $response = $this
            ->actingAs($user)
            ->postJson(
                route('endorsement_requests.store', ['position' => $position->id]),
                [
                    'endorsers' => [
                        [
                            'name' => $endorserName1,
                            'email' => $endorserEmail1,
                        ],
                        [
                            'name' => $endorserName2,
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
                route('endorsement_requests.store', ['position' => $position->id]),
                [
                    'endorsers' => [
                        [
                            'name' => $endorserName1,
                            'email' => $endorserEmail1,
                        ],
                        [
                            'name' => $endorserName2,
                            'email' => $endorserEmail2,
                        ],
                    ],
                ]
            );

        // then
        Mail::assertSent(EndorsementRequestEmail::class, 2);
        $this->assertCount(2, Endorsement::all()->toArray());
    }

    /** SHOW */
    // authorization
    // validation
    // general logic
    /** EDIT */
    // authorization
    // validation
    // general logic
    /** UPDATE */
    // authorization
    // validation
    // general logic
    /** DELETE */
    // authorization
    // validation
    // general logic
}
