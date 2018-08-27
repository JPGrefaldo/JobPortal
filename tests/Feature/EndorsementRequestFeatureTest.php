<?php

namespace Tests\Feature;

use App\Mail\EndorsementRequestEmail;
use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\EndorsementRequest;
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
    // this is defered to Crew\PositionController@show

    /** STORE */
    // authorization

    /**
     * @test
     */
    public function endorsee_can_only_ask_endorsement_for_applied_positions()
    {
        // given
        $endorsee = factory(Crew::class)->states('withRole')->create();
        $nonAppliedPosition = factory(Position::class)->create();

        // when
        $response = $this->actingAs($endorsee->user)
            ->post(route('endorsement_requests.store', $nonAppliedPosition));

        // then
        $response->assertForbidden();
    }

    // validation
    /**
     * @test
     */
    public function endorsee_must_provide_valid_endorser_information()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorsee = factory(Crew::class)->states('withRole')->create();
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->make();
        $endorsee->applyFor($position, $crewPosition->toArray());

        // when
        $response = $this
        ->actingAs($endorsee->user)
        ->post(
            route('endorsement_requests.store', $position),
            [
                'endorsers' => [
                    [
                        'name' => '',
                        'email' => '',
                    ],
                    [
                        'name' => 'Ron Swanson',
                        'email' => 'Mambo No. 5',
                    ],
                ],
            ]
            );

        // then
        $response->assertSessionHasErrors([
            'endorsers.0.name' => 'The endorsers.0.name field is required.',
            'endorsers.0.email' => 'The endorsers.0.email field is required.',
            'endorsers.1.email' => 'The endorsers.1.email must be a valid email address.',
        ]);
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
}
