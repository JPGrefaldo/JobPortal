<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\ProjectJob;
use Tests\Browser\Pages\ProjectJobIndexPage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EndorsementTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_user_can_endorse_another_user()
    {
        $endorser = factory(User::class)->create();
        $endorsee = factory(User::class)->create();

        $projectJob = factory(ProjectJob::class)->create();

        $this->browse(function (Browser $browser) use ($endorser, $endorsee, $projectJob) {
            $browser->loginAs($endorser)
                ->visit(new ProjectJobIndexPage($projectJob))
                ->endorse($endorsee);
        });

        $this->assertDatabaseHas('endorsements', [
            'project_job_id' => $projectJob->id,
            'endorser_id' => $endorser->id,
            'endorsee_id' => $endorsee->id,
        ]);
    }
}
