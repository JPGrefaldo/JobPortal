<?php

namespace Tests\Unit\Models;

use App\Models\ProjectJob;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProjectJobTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_gets_endorsements_sorted_by_top_contender()
    {
        $projectJob = factory(ProjectJob::class)->create();

        $endorser1 = factory(User::class)->create();
        $endorsee1 = factory(User::class)->create();

        $endorser1->endorse($endorsee1, $projectJob);

        $endorser2 = factory(User::class)->create();
        $endorser3 = factory(User::class)->create();
        $endorsee2 = factory(User::class)->create();

        $endorser2->endorse($endorsee1, $projectJob);
        $endorser3->endorse($endorsee1, $projectJob);

        $endorser4 = factory(User::class)->create();
        $endorser5 = factory(User::class)->create();
        $endorser6 = factory(User::class)->create();
        $endorsee3 = factory(User::class)->create();

        $endorser4->endorse($endorsee2, $projectJob);
        $endorser5->endorse($endorsee2, $projectJob);
        $endorser6->endorse($endorsee3, $projectJob);

        $endorsees = collect([
            $endorsee3,
            $endorsee2,
            $endorsee1,
        ]);

        $this->assertEquals(
            $endorsees->pluck('id'),
            $projectJob->endorsements->pluck('endorsee_id')
        );
    }
}
