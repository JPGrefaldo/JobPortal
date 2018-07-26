<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\PositionShowPage;
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
        // given
        // an endorsee
        // position
        $endorser = [
            'name'  => $this->faker->name,
            'email' => $this->faker->email,
        ];

        // when
        // endorsee visits a position
        // and he asksEndorsement
        $this->browse(function (Browser $browser) use ($endorser) {
            $browser->loginAs(1)
                ->visit(new PositionShowPage())
                ->askEndorsement($endorser);
        });

        // then
        // check a response
        // he will see "We have emailed name about your endorsement request
    }
}
