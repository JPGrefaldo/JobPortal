<?php

namespace Tests\Unit\Actions\Endorsement;

use App\Actions\Endorsement\CreateEndorsementRequest;
use App\Models\CrewPosition;
use App\Models\EndorsementEndorser;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\EndorsementRequestEmail;

class CreateEndorsementRequestTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var CreateEndorsementRequest
     */
    public $service;

    public function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        $this->service = app(CreateEndorsementRequest::class);
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\CreateEndorsementRequest::execute
     */
    public function execute_with_non_user_endorser()
    {
        $user = $this->createCrew();
        $crew = $user->crew;
        $position = Position::inRandomOrder()->get()->first();

        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id'     => $crew->id,
            'position_id' => $position,
        ]);

        $email = 'test@test.com';
        $message = 'Endorse me please!';

        $endorsement = $this->service->execute($user, $position, $email, $message, $user->id);

        $this->assertDatabaseHas('endorsement_endorsers', [
            'user_id'       => null,
            'email'         => $email,
            'request_owner_id' => $user->id,
        ]);

        $this->assertDatabaseHas('endorsement_requests', [
            'message' => $message,
        ]);

        $this->assertEquals($crewPosition->id, $endorsement->crew_position_id);

        Mail::assertSent(
            EndorsementRequestEmail::class,
            function ($mail) use ($email) {
                return
                    $mail->hasTo($email);
            }
        );
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\CreateEndorsementRequest::execute
     */
    public function execute_with_user_endorser()
    {
        $endorser = $this->createCrew();

        $user = $this->createCrew();
        $crew = $user->crew;
        $position = Position::inRandomOrder()->get()->first();
        $crewPosition = factory(CrewPosition::class)->create([
            'crew_id'     => $crew->id,
            'position_id' => $position,
        ]);

        $message = 'Endorse me please!';

        $endorsement = $this->service->execute($user, $position, $endorser->email, $message, $user->id);

        $this->assertDatabaseHas('endorsement_endorsers', [
            'user_id'       => $endorser->id,
            'email'         => null,
            'request_owner_id' => $user->id,
        ]);

        $this->assertDatabaseHas('endorsement_requests', [
            'message' => $message,
        ]);

        $this->assertEquals($crewPosition->id, $endorsement->crew_position_id);

        Mail::assertSent(
            EndorsementRequestEmail::class
        );
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\CreateEndorsementRequest::execute
     */
    public function execute_with_multiple_same_email_endorser()
    {
        $user = $this->createCrew();
        $crew = $user->crew;
        $position = Position::inRandomOrder()->get()->first();

        factory(CrewPosition::class)->create([
            'crew_id'     => $crew->id,
            'position_id' => $position,
        ]);

        $email = 'test@test.com';
        $message = 'Endorse me please!';

        $this->service->execute($user, $position, $email, $message, $user->id);
        $this->service->execute($user, $position, $email, $message, $user->id);
        $this->service->execute($user, $position, $email, $message, $user->id);

        $this->assertDatabaseHas('endorsement_endorsers', [
            'user_id'       => null,
            'email'         => $email,
            'request_owner_id' => $user->id,
        ]);

        $this->assertEquals(1, EndorsementEndorser::whereEmail($email)->get()->count());

        Mail::assertSent(
            EndorsementRequestEmail::class
        );
    }
}
