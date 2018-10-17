<?php

namespace Tests\Feature\Crew;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\EndorsementRequest;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class EndorsementFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh, WithFaker;

    protected $user;
    protected $crew;

    public function setUp()
    {
        parent::setup();

        $this->user = factory(User::class)->states('withCrewRole')->create();
        $this->crew = factory(Crew::class)->create([
            'user_id' => $this->user->id
        ]);
    }

    /** CREATE */
    // authorization
    // general logic
    /**
     * @test
     */
    public function endorsers_with_endorsement_link_can_see_endorsement_comment_create_page()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorsementRequest = factory(EndorsementRequest::class)->create();

        // when
        $response = $this
            ->actingAs($this->user)
            ->get(route('endorsements.create', $endorsementRequest));

        // then
        $response->assertSee(
            'Approve endorsement request'
        );
    }

    /**
     * @test
     */
    public function endorsee_must_not_see_endorsement_creation_page_for_his_own_endorsement_requests()
    {
        // $this->withoutExceptionHandling();
        // given
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $this->crew->id, 'position_id' => $position->id
        ]);
        $endorsementRequest = factory(EndorsementRequest::class)->create(['crew_position_id' => $crewPosition->id]);

        // when
        $response = $this->actingAs($this->user)
            ->get(route('endorsements.create', $endorsementRequest));

        // then
        $response->assertRedirect(route('crew_position.show', $position));
    }

    /**
     * @test
     */
    public function if_endorser_already_approved_a_request_then_he_is_redirected_to_edit_endorsement_comment()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorsement = factory(Endorsement::class)
            ->states('approved')
            ->create(['endorser_id' => $this->crew->id]);
        $endorsementRequest = $endorsement->request;

        // when
        $response = $this->actingAs($this->user)
            ->get(route('endorsements.create', $endorsementRequest));

        // then
        $response->assertRedirect(route('endorsements.edit', $endorsementRequest));
    }

    /** STORE */
    // authorization

    /**
     * @test
     */
    public function an_endorsee_can_not_endorse_himself()
    {
        // given
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $this->crew->id
        ]);
        $endorsementRequest = factory(EndorsementRequest::class)->create([
            'crew_position_id' => $crewPosition->id
        ]);

        // when
        $response = $this
            ->actingAs($this->user)
            ->postJson(route('endorsements.store', ['endorsementRequest' => $endorsementRequest]), [
                'comment' => 'I hope I can endorse myself',
            ]);

        // then
        $this->assertCount(0, Endorsement::all()->toArray());
    }

    // validation
    // general logic
    /**
     * @test
     */
    public function endorser_can_approve_a_pending_endorsement_request()
    {
        // $this->withoutExceptionHandling();

        // given
        $johnDoe = factory(User::class)->states('withCrewRole')->create([
            'email' => 'john@gmail.com',
        ]);
        $johnDoeCrew = factory(Crew::class)->create([
            'user_id' => $johnDoe->id,
        ]);

        $endorsementRequest = factory(EndorsementRequest::class)->create();
        // user asks endorsement
        $johnDoePendingEndorsement = factory(Endorsement::class)->create([
            'endorsement_request_id' => $endorsementRequest->id,
            'endorser_id' => null,
            'endorser_name' => 'John Doe',
            'endorser_email' => 'john@gmail.com',
        ]);

        // when
        // a endorser approves endorsement that pending
        $response = $this
            ->actingAs($johnDoe)
            ->postJson(
                route('endorsements.store', $endorsementRequest),
                ['comment' => 'This is John Doe\'s comment.',]
            )
            ->assertSuccessful();

        // then
        // only 1 instance of endorsemnt is stored
        $this->assertCount(1, Endorsement::all());
        $this->assertDatabaseHas('endorsements', [
            'endorsement_request_id' => $endorsementRequest->id,
            'endorser_id' => $johnDoeCrew->id,
            'endorser_email' => $johnDoe->email,
            'comment' => 'This is John Doe\'s comment.',
        ]);
    }

    /**
     * @test
     */
    public function endorser_can_approve_non_pending_endorsement_request()
    {
        // given
        $johnDoe = factory(User::class)->states('withCrewRole')->create([
            'email' => 'john@gmail.com',
        ]);
        $johnDoeCrew = factory(Crew::class)->create([
            'user_id' => $johnDoe->id,
        ]);

        $endorsementRequest = factory(EndorsementRequest::class)->create();

        // when
        // a Jane Doe opens endorsement request that is not pending to her name
        $response = $this
            ->actingAs($johnDoe)
            ->postJson(
                route('endorsements.store', $endorsementRequest),
                ['comment' => 'This is John Doe\'s comment.',]
            )
            ->assertSuccessful();

        // then
        // only 1 instance of endorsemnt is stored
        $this->assertCount(1, Endorsement::all());
        $this->assertDatabaseHas('endorsements', [
            'endorsement_request_id' => $endorsementRequest->id,
            'endorser_id' => $johnDoeCrew->id,
            'endorser_email' => $johnDoe->email,
            'comment' => 'This is John Doe\'s comment.',
        ]);
    }

    /**
     * @test
     */
    public function an_endorser_can_only_approve_an_endorsement_by_the_same_endorsee_once()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorsementRequest = factory(EndorsementRequest::class)->create();

        $this
            ->actingAs($this->user)
            ->postJson(
                route('endorsements.store', $endorsementRequest),
                ['comment' => 'Approving your endorsement for the first time',]
            );

        // when
        // endorser endorses the same endorsee again
        $response = $this
            ->actingAs($this->user)
            ->postJson(
                route('endorsements.store', $endorsementRequest),
                ['comment' => 'Approving your endorsement for the second time',]
            );

        // then
        $this->assertEquals(1, Endorsement::count());
        $this->assertDatabaseHas(
            'endorsements',
            [
                'endorsement_request_id' => $endorsementRequest->id,
                'comment' => 'Approving your endorsement for the first time',
            ]
        );
        $this->assertDatabaseMissing(
            'endorsements',
            [
                'endorsement_request_id' => $endorsementRequest->id,
                'comment' => 'Approving your endorsement for the second time',
            ]
        );
        $response->assertForbidden();
    }

    /** EDIT */
    // authorization
    // validation
    // general logic

    /**
     * @test
     */
    public function edit()
    {
        // given
        $endorsementRequest = factory(EndorsementRequest::class)->create();
        $endorsement = factory(Endorsement::class)->states('approved')->create([
            'endorsement_request_id' => $endorsementRequest->id,
            'endorser_id' => $this->crew->id,
        ]);

        // when
        $response = $this
            ->actingAs($this->user)
            ->get(route('endorsements.edit', $endorsementRequest));

        // then
        $response->assertSee(
            'Please feel free to leave a comment for this endorsement request.'
        );
    }

    /**
     * @test
     */
    public function endorsee_is_redirected_to_endorsement_create_page_when_editing_non_existent_endorsement()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorsementRequest = factory(EndorsementRequest::class)->create();

        // when
        $response = $this->actingAs($this->user)->get(
            route('endorsements.edit', $endorsementRequest)
        );

        // then
        $response->assertRedirect(
            route('endorsements.create', $endorsementRequest)
        );
    }

    /** UPDATE */
    // authorization
    // validation
    // general logic
    /**
     * @test
     */
    public function endorsers_can_update_their_comment()
    {
        // $this->withoutExceptionHandling();

        // given
        $endorsement = factory(Endorsement::class)
            ->states('approved')
            ->create(['endorser_id' => $this->crew->id]);
        $endorsement2 = factory(Endorsement::class)
            ->states('approved', 'withComment')
            ->create([
                'endorser_id' => $this->crew->id,
                'comment' => 'First comment'
            ]);

        // when
        $response = $this
            ->actingAs($this->user)
            ->putJson(
                route('endorsements.update', $endorsement->request),
                ['comment' => 'Forgot to add my comment, so here it is.']
            );
        $response2 = $this
            ->actingAs($this->user)
            ->putJson(
                route('endorsements.update', $endorsement2->request),
                ['comment' => 'I changed my mind. Here is my new comment.']
            );

        // then
        $this->assertDatabaseHas('endorsements', [
            'id' => $endorsement->id,
            'comment' => 'Forgot to add my comment, so here it is.'
        ]);
        $this->assertDatabaseHas('endorsements', [
            'id' => $endorsement2->id,
            'comment' => 'I changed my mind. Here is my new comment.'
        ]);
        $response->assertSee('Forgot to add my comment, so here it is.');
        $response2->assertSee('I changed my mind. Here is my new comment.');
    }

    /**
     * @test
     */
    public function endorsee_cant_update_non_existing_endorsement()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorsementRequest = factory(EndorsementRequest::class)->create();

        // when
        $response = $this->actingAs($this->user)->putJson(
            route('endorsements.update', $endorsementRequest)
        );

        // then
        $response->assertForbidden();
    }

    /** DELETE */
    // authorization
    // validation
    // general logic

    /**
     * ! fails because ask endorsement is rendered by js
     * TODO: move to browser test
     */
    public function endorsee_can_only_see_endorsement_form_on_applied_positions()
    {
        // $this->withoutExceptionHandling();
        // given
        $appliedPosition = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $this->crew->id,
            'position_id' => $appliedPosition->id
        ]);
        $nonAppliedPosition = factory(Position::class)->create();

        // when he views applied position
        $response = $this->actingAs($this->user)
            ->get(route('crew_position.show', $appliedPosition));

        // then he does see the endorsement form
        $response->assertSee('Ask Endorsement');

        // when he views non applied position
        $response = $this->actingAs($this->user)
            ->get(route('crew_position.show', $nonAppliedPosition));

        // then he does not see the endorsement form
        $response->assertDontSee('Ask Endorsement');
    }
}
