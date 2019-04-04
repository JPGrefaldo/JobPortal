<?php

namespace Tests\Feature\Manager;

use App\Mail\ProjectApproveRequestEmail;
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
    public function created()
    {
        // given
        Mail::fake();
        $admin    = $this->createAdmin();
        $producer = $this->createProducer();

        // when
        factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        // then
        Mail::assertSent(
            ProjectApproveRequestEmail::class,
            function ($mail) use ($admin) {
                return $mail->hasTo($admin->email);
            }
        );
    }

    /**
     * @test
     * @covers \App\Observers\ProjectObserver::created
     */
    public function only_admin_user_can_recieve_an_email()
    {
        Mail::fake();

        $crew     = $this->createCrew();
        $producer = $this->createProducer();
        $user     = $this->createUser();

        factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        Mail::assertNothingSent(
            ProjectApproveRequestEmail::class,
            function ($mail) use ($crew) {
                return $mail->hasTo($crew->email);
            }
        );

        Mail::assertNothingSent(
            ProjectApproveRequestEmail::class,
            function ($mail) use ($producer) {
                return $mail->hasTo($producer->email);
            }
        );

        Mail::assertNothingSent(
            ProjectApproveRequestEmail::class,
            function ($mail) use ($user) {
                return $mail->hasTo($user->email);
            }
        );
    }
}
