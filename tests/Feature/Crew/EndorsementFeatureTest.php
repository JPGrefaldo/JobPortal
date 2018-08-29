<?php

namespace Tests\Feature\Crew;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\EndorsementRequest;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class EndorsementFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh, WithFaker;

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
        $endorser = factory(Crew::class)->states('withRole')->create();
        $endorsementRequest = factory(EndorsementRequest::class)->create();

        // when
        $response = $this->actingAs($endorser->user)->get(route('endorsements.create', $endorsementRequest));

        // then
        $response->assertSee('Please feel free to leave a comment for this endorsement request.');
    }

    /**
     * @test
     */
    public function endorsee_must_not_see_endorsement_creation_page_for_his_own_endorsement_requests()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorsee = factory(Crew::class)->states('withRole')->create();
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create(['crew_id' => $endorsee->id, 'position_id' => $position->id]);
        $endorsementRequest = factory(EndorsementRequest::class)->create(['crew_position_id' => $crewPosition->id]);

        // when
        $response = $this->actingAs($endorsee->user)
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
        $endorser = factory(Crew::class)->states('withRole')->create();
        $endorsement = factory(Endorsement::class)->states('approved')->create(['endorser_email' => $endorser->user->email]);
        $endorsementRequest = $endorsement->request;

        // when
        $response = $this->actingAs($endorser->user)
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
        $endorsee = factory(Crew::class)->states('withRole')->create();
        $crewPosition = factory(CrewPosition::class)->create(['crew_id' => $endorsee->id]);
        $endorsementRequest = factory(EndorsementRequest::class)->create(['crew_position_id' => $crewPosition->id]);

        // when
        $response = $this
            ->actingAs($endorsee->user)
            ->postJson(route('endorsements.store', ['endorsementRequest' => $endorsementRequest]), [
                'comment' => $this->faker->sentence,
            ]);

        // then
        $this->assertCount(0, Endorsement::all()->toArray());
    }

    // validation
    // general logic
    /**
     * @test
     */
    public function endorser_can_approve_an_endorsement()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorsementRequest = factory(EndorsementRequest::class)->create();
        $endorser1 = factory(Crew::class)->states('withRole')->create();
        $endorser2 = factory(Crew::class)->states('withRole')->create();

        // when
        $response1 = $this
            ->actingAs($endorser1->user)
            ->postJson(route('endorsements.store', ['endorsementRequest' => $endorsementRequest]), [
                'comment' => $this->faker->sentence,
            ])
            ->assertSuccessful()
            ->assertJsonStructure(['approved_at', 'comment']);

        $response2 = $this
            ->actingAs($endorser2->user)
            ->postJson(route('endorsements.store', ['endorsementRequest' => $endorsementRequest]), [
                'comment' => '',
            ])
            ->assertSuccessful()
            ->assertJsonStructure(['approved_at', 'comment']);

        // then
        $this->assertCount(2, Endorsement::all()->toArray());
    }

    /**
     * @test
     */
    public function an_endorser_can_only_approve_an_endorsement_by_the_same_endorsee_once()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorsementRequest = factory(EndorsementRequest::class)->create();
        $endorser = factory(Crew::class)->states('withRole')->create();
        $comment = $this->faker->sentence;

        $response = $this
            ->actingAs($endorser->user)
            ->postJson(route('endorsements.store', ['endorsementRequest' => $endorsementRequest]), [
                'comment' => $comment,
            ]);

        // when
        // endorser endorses the same endorsee again
        $response = $this
            ->actingAs($endorser->user)
            ->postJson(route('endorsements.store', ['endorsementRequest' => $endorsementRequest]), [
                'comment' => $comment,
            ]);

        // then
        // endorser is forbidden
        $this->assertCount(1, Endorsement::all()->toArray());
    }

    /** EDIT */
    // authorization
    // validation
    // general logic

    /** UPDATE */
    // authorization
    // validation
    // general logic
    /**
     * @test
     */
    public function endorsers_can_update_their_comment()
    {
        $this->withoutExceptionHandling();
        // given
        $comment = $this->faker->sentence;
        $comment2 = $this->faker->sentence;
        $endorser = factory(Crew::class)->states('withRole')->create();
        $endorsement = factory(Endorsement::class)->states('approved')->create(['endorser_email' => $endorser->user->email]);
        $endorsement2 = factory(Endorsement::class)->states('approved', 'withComment')->create(['endorser_email' => $endorser->user->email]);

        // when
        $response = $this->actingAs($endorser->user)->putJson(route('endorsements.update', $endorsement->request), ['comment' => $comment]);
        $response = $this->actingAs($endorser->user)->putJson(route('endorsements.update', $endorsement2->request), ['comment' => $comment2]);

        // then
        $this->assertDatabaseHas('endorsements', ['comment' => $comment]);
        $this->assertDatabaseHas('endorsements', ['comment' => $comment2]);
    }

    /** DELETE */
    // authorization
    // validation
    // general logic

    /**
     * TODO: move this to crew/position/show
     * @test
     */
    public function endorsee_can_only_see_endorsement_form_on_applied_positions()
    {
        // $this->withoutExceptionHandling();
        // given
        $endorsee = factory(Crew::class)->states('withRole')->create();
        $appliedPosition = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create(['crew_id' => $endorsee->id, 'position_id' => $appliedPosition->id]);
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
}