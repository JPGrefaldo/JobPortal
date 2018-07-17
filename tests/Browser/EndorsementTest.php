<?php

namespace Tests\Browser;

use App\Models\CrewPosition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CrewPositionShowPage;
use Tests\DuskTestCase;
use Tests\Support\SeedDatabaseAfterRefresh;

class EndorsementTest extends DuskTestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh, WithFaker;

    /**
     * @test
     */
    public function an_endorsee_can_ask_an_endorsement_from_an_endorser_by_endorsers_email()
    {
        $endorsee      = factory(User::class)->create();
        $crewPosition  = factory(CrewPosition::class)->create(['crew_id' => $endorsee->id]);
        $endorserEmail = $this->faker->email;

        $this->browse(function (Browser $browser) use ($crewPosition, $endorsee, $endorserEmail) {
            $browser->loginAs($endorsee)
                ->visit(new CrewPositionShowPage($crewPosition))
                ->askEndorsement($endorserEmail);
        });

        $this->assertDatabaseHas('endorsements', [
            'crew_position_id' => $crewPosition->id,
            'endorser_email'   => $endorserEmail,
            'completed'        => false,
            'deleted'          => false,
        ]);
    }

    /**
     * @test
     */
    public function an_endorser_accepts_endorsement_of_an_endorsee()
    {
        $this->assertDatabaseHas('endorsements', [
            'crew_position_id' => $crewPosition->id,
            'endorsee_id'      => $endorsee->id,
            'endorser_email'   => $endorser->email,
            'comment'          => $endorsement->comment,
            'completed'        => true,
            'deleted'          => false,
        ]);
    }
}
