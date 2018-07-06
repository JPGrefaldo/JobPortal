<?php

namespace Tests\Browser\Pages;

use App\Models\Project;
use App\Models\ProjectJob;
use Laravel\Dusk\Browser;

class ProjectJobIndexPage extends Page
{
    protected $job;

    public function __construct(ProjectJob $job)
    {
        $this->job = $job;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/projects/' . $this->job->project->id . '/jobs/' . $this->job->id;
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

    public function endorse(Browser $browser, $endorsee)
    {
        $browser
            // ->press('Endorse a good candidate')
            ->type('endorsee_email', $endorsee->email)
            ->press('Endorse');
    }
}
