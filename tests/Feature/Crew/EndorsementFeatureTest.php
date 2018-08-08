<?php

namespace Tests\Feature\Crew;

use App\EndorsementRequest;
use App\Mail\EndorsementRequestEmail;
use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\Position;
use App\Models\User;
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
        Mail::fake();

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
                route('endorsement-request.store', ['position' => $position->id]),
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
        $this->assertCount(2, Endorsement::all()->toArray());

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
                route('endorsement-request.store', ['position' => $position->id]),
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
                route('endorsement-request.store', ['position' => $position->id]),
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
                route('endorsement-request.store', ['position' => $position->id]),
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
        $comment  = $this->faker->sentence;

        $response = $this
            ->actingAs($endorser->user)
            ->postJson(route('endorsement.store', ['endorsementRequest' => $endorsementRequest]), [
                'comment' => $comment,
            ]);

        // when
        // endorser endorses the same crew again
        $response = $this
            ->actingAs($endorser->user)
            ->postJson(route('endorsement.store', ['endorsementRequest' => $endorsementRequest]), [
                'comment' => $comment,
            ]);

        // then
        // endorser is forbidden
        $this->assertCount(1, Endorsement::all()->toArray());
    }

    /**
     * @test
     */
    public function an_endorsee_can_not_endorse_himself()
    {
        // given
        $endorsee           = factory(Crew::class)->states('withRole')->create();
        $crewPosition       = factory(CrewPosition::class)->create(['crew_id' => $endorsee->id]);
        $endorsementRequest = factory(EndorsementRequest::class)->create(['crew_position_id' => $crewPosition->id]);

        // when
        $response = $this
            ->actingAs($endorsee->user)
            ->postJson(route('endorsement.store', ['endorsementRequest' => $endorsementRequest]), [
                'comment' => $this->faker->sentence,
            ]);

        // then
        $this->assertCount(0, Endorsement::all()->toArray());
    }

    /**
     * @test
     */
    public function if_user_already_approved_a_request_he_is_redirected_to_edit_comment()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorser           = factory(Crew::class)->states('withRole')->create();
        $endorsement        = factory(Endorsement::class)->states('approved')->create(['endorser_id' => $endorser->user->id]);
        $endorsementRequest = $endorsement->request;

        // when
        $response = $this->actingAs($endorser->user)
            ->get(route('endorsement.create', ['endorsementRequest' => $endorsementRequest]));

        // then
        $response->assertRedirect(route('endorsement.edit', ['endorsementRequest' => $endorsementRequest]));
        $this->assertCount(1, Endorsement::all()->toArray());
    }

    /**
     * @test
     */
    public function endorsee_can_only_see_endorsement_form_on_applied_positions()
    {
        $this->withoutExceptionHandling();
        // given
        $endorsee           = factory(Crew::class)->states('withRole')->create();
        $appliedPosition    = factory(Position::class)->create();
        $crewPosition       = factory(CrewPosition::class)->create(['crew_id' => $endorsee->id, 'position_id' => $appliedPosition->id]);
        $nonAppliedPosition = factory(Position::class)->create();

        // when he views applied position
        $response = $this->actingAs($endorsee->user)
            ->get(route('crew_position.show', $appliedPosition));

        // then he does see the endorsement form
        $response->assertSee('Ask Endorsement');

        // when he views non applied position
        $response = $this->actingAs($endorsee->user)
            ->get(route('crew_position.show', $nonAppliedPosition));

        // then he does not see the endorsement form
        $response->assertDontSee('Ask Endorsement');
    }

    /**
     * @test
     */
    public function endorsee_can_only_ask_endorsement_for_applied_positions()
    {
        // given
        $endorsee = factory(Crew::class)->states('withRole')->create();
        $nonAppliedPosition = factory(Position::class)->create();

        // when
        $response = $this->actingAs($endorsee->user)->post(route('endorsement-request.store', $nonAppliedPosition));

        // then
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function endorsee_must_not_see_endorsement_creation_page_for_his_own_endorsement_request()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorser = factory(Crew::class)->states('withRole')->create();
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create(['crew_id' => $endorser->id, 'position_id' => $position->id]);
        $endorsementRequest = factory(EndorsementRequest::class)->create(['crew_position_id' => $crewPosition->id]);

        // when
        $response = $this->actingAs($endorser->user)
        ->get(route('endorsement.create', $endorsementRequest));

        // then
        $response->assertRedirect(route('crew_position.show', $position));
    }

    /**
     * @test
     */
    public function endorsers_with_endorsement_link_can_see_endorsement_comment_create_page()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorser = factory(Crew::class)->states('withRole')->create();
        $endorsementRequest = factory(EndorsementRequest::class)->create();

        // when
        $response = $this->actingAs($endorser->user)->get(route('endorsement.create', $endorsementRequest));

        // then
        $response->assertSee('Please feel free to leave a comment for this endorsement request.');
    }

    /**
     * @test
     */
    public function endorsers_trying_to_view_create_endorsement_is_redirected_to_edit()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorser = factory(Crew::class)->states('withRole')->create();
        $endorsementRequest = factory(EndorsementRequest::class)->create();

        // when
        $response = $this
            ->actingAs($endorser->user)
            ->postJson(route('endorsement.store', ['endorsementRequest' => $endorsementRequest]), [
                'comment' => $this->faker->sentence,
            ]);
        $response = $this->actingAs($endorser->user)->get(route('endorsement.create', $endorsementRequest));

        // then
        $response->assertRedirect(route('endorsement.edit', $endorsementRequest));
    }
}
