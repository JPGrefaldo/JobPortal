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

    protected $user;
    protected $crew;

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
    // this is defered to Crew\EndorsementPositionController@show

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
        $data = [
            'name' => '',
            'email' => '',
        ];
        $response = $this->askEndorsementFor($position, $data);

        // then
        $response->assertJsonValidationErrors([
            'name',
            'email',
        ]);

        // when
        $data = [
            'name' => 'John Doe',
            'email' => 'not an email',
        ];
        $response = $this->askEndorsementFor($position, $data);

        // then
        $response->assertJsonValidationErrors([
            'email',
        ]);

        // when
        $data = [
            'name' => '',
            'email' => 'john@example.com',
        ];
        $response = $this->askEndorsementFor($position, $data);

        // then
        $response->assertJsonValidationErrors([
            'name',
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

        $data = [
            'name' => 'John Doe',
            'email' => 'john@email.com',
        ];

        // when
        $response = $this->askEndorsementFor($position, $data);

        // then
        $endorsementRequest = EndorsementRequest::first();
        $this->assertCount(1, EndorsementRequest::all());
        $this->assertCount(1, Endorsement::all());

        $this->assertDatabaseHas('endorsement_requests', [
            'crew_position_id' => $crewPosition->id,
        ]);

        $this->assertDatabaseHas('endorsements', [
            'endorsement_request_id' => $endorsementRequest->id,
            'endorser_name' => 'John Doe',
            'endorser_email' => 'john@email.com',
        ]);

        $this->assertDatabaseHas('endorsements', [
            'endorsement_request_id' => $endorsementRequest->id,
            'endorser_name' => 'John Doe',
            'endorser_email' => 'john@email.com',
        ]);
        $response->assertSuccessful();
        $response->assertSee('Success');
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

        // when
        $response = $this->askEndorsementFor($position, $this->data());

        // then
        $endorsementRequest = EndorsementRequest::first();
        Mail::assertSent(EndorsementRequestEmail::class, 1);
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
    public function an_endorsee_can_only_ask_to_be_endorsed_by_the_same_endorser_once()
    {
        // $this->withoutExceptionHandling();
        // given

        Mail::fake();
        $position = factory(Position::class)->create();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id' => $this->endorsee->id,
            'position_id' => $position->id,
        ]);

        $response = $this->askEndorsementFor($position, $this->data());

        // when
        // endorsee asks for endorsement again
        $response = $this->askEndorsementFor($position, $this->data());

        // then
        Mail::assertSent(EndorsementRequestEmail::class, 1);
        $this->assertCount(1, Endorsement::all());
        $response->assertSee('We already sent john.doe@google.com a request');
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

    protected function data()
    {
        return [
            'name' => 'John Doe',
            'email' => 'john.doe@google.com',
        ];
    }
}
