<?php

namespace Tests\Feature\Producer;

use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\User;
use Tests\Support\Data\PayTypeID;
use Tests\Support\Data\PositionID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateProjectJobTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /** @test */
    public function update()
    {
        $this->markTestIncomplete();
        $user = $this->createProducer();
        $job  = $this->createJob($user, ['position_id' => PositionID::CAMERA_OPERATOR]);
        $data = [
            'persons_needed'       => '3',
            'gear_provided'        => 'Updated Gear Provided',
            'gear_needed'          => 'Updated Gear Needed',
            'pay_rate'             => '17',
            'pay_rate_type_id'     => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Updated Notes',
            'travel_expenses_paid' => '1',
            'rush_call'            => '0',
        ];

        $response = $this->actingAs($user)->put('/producer/jobs/' . $job->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset([
            'persons_needed'       => 3,
            'gear_provided'        => 'Updated Gear Provided',
            'gear_needed'          => 'Updated Gear Needed',
            'pay_rate'             => '17',
            'pay_rate_type_id'     => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Updated Notes',
            'travel_expenses_paid' => true,
            'rush_call'            => false,
        ], $job->toArray()->refresh());
    }

    /** @test */
    public function update_invalid_required()
    {
        $user = $this->createProducer();
        $job  = $this->createJob($user);
        $data = [
            'dates_needed'         => '',
            'notes'                => '',
            'travel_expenses_paid' => '',
            'rush_call'            => '',
        ];

        $response = $this->actingAs($user)->put('/producer/jobs/' . $job->id, $data);

        $response->assertSessionHasErrors([
            'dates_needed',
            'notes',
            'travel_expenses_paid',
            'rush_call',
        ]);
    }

    /** @test */
    public function update_invalid_required_sometimes()
    {
        $user = $this->createProducer();
        $job  = $this->createJob($user);
        $data = [
            'persons_needed' => '',
        ];

        $response = $this->actingAs($user)->put('/producer/jobs/' . $job->id, $data);

        $response->assertSessionHasErrors([
            'persons_needed',
        ]);
    }

    /** @test */
    public function update_invalid_data()
    {
        $user = $this->createProducer();
        $job  = $this->createJob($user);
        $data = [
            'persons_needed'       => 'asdasd',
            'gear_provided'        => false,
            'gear_needed'          => false,
            'pay_rate'             => 'asdasd',
            'pay_rate_type_id'     => 999,
            'pay_type_id'          => 999,
            'dates_needed'         => false,
            'notes'                => false,
            'travel_expenses_paid' => 'asdasd',
            'rush_call'            => 'asdasd',
        ];

        $response = $this->actingAs($user)->put('/producer/jobs/' . $job->id, $data);

        $response->assertSessionHasErrors([
            'persons_needed', // must be numeric
            'gear_provided', // must be a string
            'gear_needed', // must be a string
            'pay_rate', // must be numeric
            'pay_rate_type_id', // must exist on the pay_rates table
            'pay_type_id', // must exist on the pay_rates table
            'dates_needed', // must be a string
            'notes', // must be a string
            'travel_expenses_paid', // must be a boolean
            'rush_call', // must be a boolean
        ]);
    }

    /** @test */
    public function update_unauthorized_role()
    {
        $user = $this->createCrewUser();
        $job  = factory(ProjectJob::class)->create();
        $data = [];

        $response = $this->actingAs($user)->put('/producer/jobs/' . $job->id, $data);

        $response->assertRedirect('/');
    }

    /** @test */
    public function update_nonexisting()
    {
        $user = $this->createProducer();
        $data = [];

        $response = $this->actingAs($user)->put('/producer/jobs/' . 999, $data);

        $response->assertNotFound();
    }

    /** @test */
    public function update_unauthorized_user()
    {
        $user    = $this->createProducer();
        $project = factory(ProjectJob::class)->create();
        $data    = [];

        $response = $this->actingAs($user)->put('/producer/jobs/' . $project->id, $data);

        $response->assertForbidden();
    }


    /**
     * @param \App\Models\User $user
     * @param array            $attributes
     *
     * @return \App\Models\ProjectJob
     */
    public function createJob(User $user, $attributes = [])
    {
        $project = factory(Project::class)->create([
            'user_id' => $user->id,
            'site_id' => $this->getCurrentSite()->id,
        ]);

        $attributes['project_id'] = $project->id;

        return factory(ProjectJob::class)->create($attributes);
    }
}
