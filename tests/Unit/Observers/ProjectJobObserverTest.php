<?php

namespace Tests\Unit\Observers;

use App\Mail\RushCallEmail;
use App\Models\CrewPosition;
use App\Models\ProjectJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ProjectJobObserverTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Observers\ProjectJobObserver::created
     */
    public function should_send_email_to_the_crew_with_the_same_position_needed_for_the_job()
    {
        Mail::fake();

        $crew = $this->createCrew();

        factory(CrewPosition::class)->create([
            'crew_id'       => 1,
            'position_id'   => 1,
        ]);

        factory(ProjectJob::class)->create([
            'position_id'   => 1,
            'project_id'    => 1,
            'rush_call'     => 1,
        ]);

        Mail::assertSent(
            RushCallEmail::class,
            function ($mail) use ($crew) {
                return $mail->hasTo($crew->email);
            }
        );
    }

    /**
     * @test
     * @covers \App\Observers\ProjectJobObserver::created
     */
    public function should_not_send_email_to_the_crew_not_the_same_position_needed_for_the_job()
    {
        Mail::fake();

        $crew = $this->createCrew();

        factory(CrewPosition::class)->create([
            'crew_id'       => 1,
            'position_id'   => 1,
        ]);

        factory(ProjectJob::class)->create([
            'position_id'   => 2,
            'project_id'    => 1,
            'rush_call'     => 1,
        ]);

        Mail::assertNothingSent(
            RushCallEmail::class,
            function ($mail) use ($crew) {
                return $mail->hasTo($crew->email);
            }
        );
    }

    /**
     * @test
     * @covers \App\Observers\ProjectJobObserver::created
     */
    public function should_send_email_when_job_is_rush_call()
    {
        Mail::fake();

        $crew = $this->createCrew();

        factory(CrewPosition::class)->create([
            'crew_id'       => 1,
            'position_id'   => 1,
        ]);

        factory(ProjectJob::class)->create([
            'position_id'   => 1,
            'project_id'    => 1,
            'rush_call'     => 1,
        ]);

        Mail::assertSent(
            RushCallEmail::class,
            function ($mail) use ($crew) {
                return $mail->hasTo($crew->email);
            }
        );
    }

    /**
     * @test
     * @covers \App\Observers\ProjectJobObserver::created
     */
    public function should_not_send_email_when_job_is_not_rush_call()
    {
        Mail::fake();
        $crew = $this->createCrew();

        factory(CrewPosition::class)->create([
            'crew_id'       => 1,
            'position_id'   => 1,
        ]);

        factory(ProjectJob::class)->create([
            'position_id'   => 1,
            'project_id'    => 1,
            'rush_call'     => 0,
        ]);

        Mail::assertNothingSent(
            RushCallEmail::class,
            function ($mail) use ($crew) {
                return $mail->hasTo($crew->email);
            }
        );
    }
    

    /**
     * @test
     * @covers \App\Observers\ProjectJobObserver::created
     */
    public function should_not_send_email_to_non_crew()
    {
        Mail::fake();

        $admin    = $this->createAdmin();
        $producer = $this->createProducer();
        $user     = $this->createUser();

        factory(ProjectJob::class)->create([
            'project_id' => 1,
            'rush_call'  => 1,
        ]);

        Mail::assertNothingSent(
            RushCallEmail::class,
            function ($mail) use ($admin) {
                return $mail->hasTo($admin->email);
            }
        );

        Mail::assertNothingSent(
            RushCallEmail::class,
            function ($mail) use ($producer) {
                return $mail->hasTo($producer->email);
            }
        );

        Mail::assertNothingSent(
            RushCallEmail::class,
            function ($mail) use ($user) {
                return $mail->hasTo($user->email);
            }
        );
    }
}
