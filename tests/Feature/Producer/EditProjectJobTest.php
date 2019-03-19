<?php

namespace Tests\Feature\Producer;

use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\Data\PayTypeID;
use Tests\Support\Data\PositionID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use App\Models\Site;

class EditProjectJobTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectJobsController::create
     */
    public function return_project_should_have_included_remotes_and_sites()
    {
        $this->withExceptionHandling();

        $user    = $this->createProducer();
        $project = $this->createProject($user);
        $job     = [
                        'persons_needed'       => '2',
                        'gear_provided'        => 'Some Gear Provided',
                        'gear_needed'          => 'Some Gear Needed',
                        'pay_rate'             => '16',
                        'pay_type_id'          => PayTypeID::PER_HOUR,
                        'dates_needed'         => '6/15/2018 - 6/25/2018',
                        'notes'                => 'Some Note',
                        'travel_expenses_paid' => '1',
                        'rush_call'            => '1',
                        'position_id'          => PositionID::CAMERA_OPERATOR,
                        'project_id'           => $project->id,
                    ];
        $sites   = collect(1,2,3);

        $project->jobs()->create($job);

        $sites->each(function($site) use($project){
            $project->remotes()
                    ->create([
                        'site_id' => $site
                    ]);
        });
    
        $response = $this->actingAs($user)
                         ->get(route('producer.projects.edit', $project->id));
        
        $response->assertJsonFragment($project->toArray());
        $response->assertJsonFragment($project->jobs->toArray());
        $response->assertJsonFragment($project->remotes->toArray());
    }

    /**
     * @param \App\Models\User $user
     *
     * @return \App\Models\Project
     */
    private function createProject(User $user)
    {
        $attributes['user_id'] = $user->id;
        $attributes['site_id'] = $this->getCurrentSite()->id;

        return factory(Project::class)->create($attributes);
    }

}