<?php

namespace Tests\Browser;

use App\Models\CrewPosition;
use App\Models\ProjectJob;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CrewPositionShowPage;
use Tests\Browser\Pages\ProjectJobIndexPage;
use Tests\DuskTestCase;

class EndorsementTest extends DuskTestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * @test
     */
    public function an_endorsee_can_ask_an_endorsement_from_an_endorser()
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
