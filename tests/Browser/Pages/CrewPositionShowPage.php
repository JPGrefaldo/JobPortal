<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class CrewPositionShowPage extends Page
{
    protected $crewPosition;

    public function __construct($crewPosition)
    {
        $this->crewPosition = $crewPosition;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/crew-positions/' . $this->crewPosition->id;
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            // '@element' => '#selector',
        ];
    }

    public function askEndorsement(Browser $browser, $endorserEmail)
    {
        $browser
        // after pressing ask endorsement, it will show the textbox for endorser email
        // ->press('Ask Endorsement')
            ->value('@endorser_email', $endorserEmail)
            ->click('@ask_endorsement');
    }
}
