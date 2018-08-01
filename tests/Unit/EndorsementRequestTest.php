<?php

namespace Tests\Unit;

use App\EndorsementRequest;
use App\Models\Endorsement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class EndorsementRequestTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;
    /**
     * @test
     */
    public function endorsements()
    {
        // given
        $endorsementRequest = factory(EndorsementRequest::class)->create();

        // when
        factory(Endorsement::class, 2)->states('approved')->create(['endorsement_request_id' => $endorsementRequest->id]);

        // then
        $this->assertCount(2, $endorsementRequest->endorsements);
    }

    /**
     * @test
     */
    public function isApprovedBy()
    {
        $this->withoutExceptionHandling();
        // given
        $user = factory(User::class)->create();
        $endorsementRequest = factory(EndorsementRequest::class)->create();

        // when
        $endorsement = factory(Endorsement::class)->states('approved')->create(['endorsement_request_id' => $endorsementRequest->id, 'endorser_id' => $user->id]);

        // then
        $this->assertTrue($endorsementRequest->isApprovedBy($user));
    }
}
