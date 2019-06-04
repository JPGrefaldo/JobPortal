<?php

namespace Tests\Unit\Observers;

use App\Mail\ProjectApprovalRequestEmail;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ProjectObserverTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Observers\ProjectObserver::created
     */
    public function should_send_email_to_the_admin()
    {
        Mail::fake();

        $admin = $this->createAdmin();
        $producer = $this->createProducer();

        factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        Mail::assertSent(
            ProjectApprovalRequestEmail::class,
            function ($mail) use ($admin) {
                return $mail->hasTo($admin->email);
            }
        );
    }

    /**
     * @test
     * @covers \App\Observers\ProjectObserver::created
     */
    public function should_not_send_email_to_non_admin()
    {
        Mail::fake();

        $crew = $this->createCrew();
        $producer = $this->createProducer();
        $user = $this->createUser();

        factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        Mail::assertNothingSent(
            ProjectApprovalRequestEmail::class,
            function ($mail) use ($crew) {
                return $mail->hasTo($crew->email);
            }
        );

        Mail::assertNothingSent(
            ProjectApprovalRequestEmail::class,
            function ($mail) use ($producer) {
                return $mail->hasTo($producer->email);
            }
        );

        Mail::assertNothingSent(
            ProjectApprovalRequestEmail::class,
            function ($mail) use ($user) {
                return $mail->hasTo($user->email);
            }
        );
    }
}
