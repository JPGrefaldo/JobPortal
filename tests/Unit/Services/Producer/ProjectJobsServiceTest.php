<?php

namespace Tests\Unit\Services\Producer;

use App\Models\ProjectJob;
use App\Services\Producer\ProjectJobsService;
use Tests\Support\Data\PayTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectJobsServiceTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var \App\Services\Producer\ProjectJobsService
     */
    private $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(ProjectJobsService::class);
    }

    /** @test */
    public function update()
    {
        $input = [
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
        $job   = factory(ProjectJob::class)->create();

        $this->service->update($input, $job);

        $this->assertArraySubset([
            'persons_needed'       => 3,
            'gear_provided'        => 'Updated Gear Provided',
            'gear_needed'          => 'Updated Gear Needed',
            'pay_rate'             => '17',
            'pay_type_id'          => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Updated Notes',
            'travel_expenses_paid' => true,
            'rush_call'            => false,
        ], $job->refresh()->toArray());
    }

    /** @test */
    public function update_with_invalid_params()
    {
        $input = [
            'persons_needed'       => '3',
            'gear_provided'        => 'Updated Gear Provided',
            'gear_needed'          => 'Updated Gear Needed',
            'pay_rate'             => '17',
            'pay_rate_type_id'     => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Updated Notes',
            'travel_expenses_paid' => '1',
            'rush_call'            => '0',
            'status'               => '1'
        ];
        $job   = factory(ProjectJob::class)->create();

        $this->service->update($input, $job);

        $this->assertArraySubset([
            'persons_needed'       => 3,
            'gear_provided'        => 'Updated Gear Provided',
            'gear_needed'          => 'Updated Gear Needed',
            'pay_rate'             => 17.00,
            'pay_type_id'          => PayTypeID::PER_HOUR,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Updated Notes',
            'travel_expenses_paid' => true,
            'rush_call'            => false,
        ], $job->refresh()->toArray());
    }

    /** @test */
    public function update_non_pay_rate()
    {
        $input = [
            'persons_needed'       => '3',
            'gear_provided'        => 'Updated Gear Provided',
            'gear_needed'          => 'Updated Gear Needed',
            'pay_rate'             => '0',
            'pay_rate_type_id'     => PayTypeID::PER_HOUR,
            'pay_type_id'          => PayTypeID::DOE,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Updated Notes',
            'travel_expenses_paid' => '1',
            'rush_call'            => '0',
        ];
        $job   = factory(ProjectJob::class)->create();

        $this->service->update($input, $job);

        $this->assertArraySubset([
            'persons_needed'       => 3,
            'gear_provided'        => 'Updated Gear Provided',
            'gear_needed'          => 'Updated Gear Needed',
            'pay_rate'             => 0.00,
            'pay_type_id'          => PayTypeID::DOE,
            'dates_needed'         => '6/15/2018 - 6/25/2018',
            'notes'                => 'Updated Notes',
            'travel_expenses_paid' => true,
            'rush_call'            => false,
        ], $job->refresh()->toArray());
    }

    /** @test */
    public function filter_update_data()
    {
        $this->assertSame(
            [
                'persons_needed'       => '3',
                'gear_provided'        => 'Updated Gear Provided',
                'gear_needed'          => 'Updated Gear Needed',
                'pay_rate'             => '17',
                'dates_needed'         => '6/15/2018 - 6/25/2018',
                'notes'                => 'Updated Notes',
                'travel_expenses_paid' => '1',
                'rush_call'            => '0',
            ],
            $this->service->filterUpdateData([
                'persons_needed'       => '3',
                'gear_provided'        => 'Updated Gear Provided',
                'gear_needed'          => 'Updated Gear Needed',
                'pay_rate'             => '17',
                'pay_rate_type_id'     => PayTypeID::PER_HOUR,
                'dates_needed'         => '6/15/2018 - 6/25/2018',
                'notes'                => 'Updated Notes',
                'travel_expenses_paid' => '1',
                'rush_call'            => '0',
                'status'               => '1',
                'project_id'           => '2',
            ])
        );
    }

    /** @test */
    public function get_pay_type_id_with_rate()
    {
        $this->assertEquals(
            PayTypeID::PER_HOUR,
            $this->service->getPayTypeId(16, [
                'pay_rate_type_id' => PayTypeID::PER_HOUR,
                'pay_type_id'      => PayTypeID::DOE,
            ])
        );
    }

    /** @test */
    public function get_pay_type_id_without_rate()
    {
        $this->assertEquals(
            PayTypeID::DOE,
            $this->service->getPayTypeId(0, [
                'pay_rate_type_id' => PayTypeID::PER_HOUR,
                'pay_type_id'      => PayTypeID::DOE,
            ])
        );
    }
}
