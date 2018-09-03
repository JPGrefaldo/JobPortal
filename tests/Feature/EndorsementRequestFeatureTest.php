<?php

namespace Tests\Feature;

use App\Mail\EndorsementRequestEmail;
use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\EndorsementRequest;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class EndorsementRequestFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh, WithFaker;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->states('withCrewRole')->create();
        $this->crew = factory(Crew::class)->create([
            'user_id' => $this->user->id
        ]);
        $this->endorsee = $this->crew;
    }

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
        $nonAppliedPosition = factory(Position::class)->create();

        // when
        $response = $this->askEndorsementFor($nonAppliedPosition);

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
        $position = factory(Position::class)->create();
        factory(CrewPosition::class)->create([
            'crew_id' => $this->crew->id,
            'position_id' => $position->id
        ]);

        // when
        $response = $this
        ->actingAs($this->user)
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
        // $this->withoutExceptionHandling();

        // given
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $this->endorsee->id,
            'position_id' => $position->id,
        ]);

        $endorserName1 = $this->faker->name;
        $endorserEmail1 = $this->faker->email;

        $endorserName2 = $this->faker->name;
        $endorserEmail2 = $this->faker->email;

        // when
        $response = $this
            ->actingAs($this->user)
            ->postJson(
                route(
                    'endorsement_requests.store',
                    ['position' => $position->id]
                ),
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
        $endorsementRequest = EndorsementRequest::first();
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
    }

    /**
     * @test
     */
    public function endorsement_request_email_is_sent_to_endorsers_after_endorsees_ask_for_an_endorsement()
    {
        // $this->withoutExceptionHandling();

        // given
        Mail::fake();

        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $this->endorsee->id,
            'position_id' => $position->id,
        ]);

        $endorserName1 = $this->faker->name;
        $endorserEmail1 = $this->faker->email;

        $endorserName2 = $this->faker->name;
        $endorserEmail2 = $this->faker->email;

        // when
        $response = $this
            ->actingAs($this->user)
            ->postJson(
                route(
                    'endorsement_requests.store',
                    ['position' => $position->id]
                ),
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
        $endorsementRequest = EndorsementRequest::first();
        Mail::assertSent(EndorsementRequestEmail::class, 2);
        Mail::assertSent(
            EndorsementRequestEmail::class,
            function ($mail) use ($endorsementRequest) {
                return $mail->endorsement->endorsement_request_id === $endorsementRequest->id;
            }
        );
    }

    /**
     * @test
     */
    public function an_endorsee_can_only_ask_to_be_endorsed_by_the_same_crew_once()
    {
        // $this->withoutExceptionHandling();
        // given

        Mail::fake();
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $this->endorsee->id,
            'position_id' => $position->id,
        ]);

        $endorserName1 = $this->faker->name;
        $endorserEmail1 = $this->faker->email;

        $endorserName2 = $this->faker->name;
        $endorserEmail2 = $this->faker->email;

        $response = $this
            ->actingAs($this->user)
            ->postJson(
                route(
                    'endorsement_requests.store',
                    ['position' => $position->id]
                ),
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
            ->actingAs($this->user)
            ->postJson(
                route(
                    'endorsement_requests.store',
                    ['position' => $position->id]
                ),
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

    protected function askEndorsementFor($position, array $formData = [])
    {
        return $this
            ->actingAs($this->user)
            ->postJson(route(
                'endorsement_requests.store',
                $position->id
            ), $formData);
    }
}
