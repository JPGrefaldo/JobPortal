<?php

namespace Tests\Unit\Listeners;

use App\Mail\ProjectDeniedEmail;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class SendProjectDeniedEmailTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Listeners\SendProjectDeniedEmail::handle
     */
    public function handle()
    {
        Mail::fake();

        $admin      = $this->createAdmin();
        $producer   = $this->createProducer();
        $project    = factory(Project::class)->create([
            'user_id' => $producer->id
        ]);
        $data       = [
            'reason' => 'Some reason'
        ];

        $this->actingAs($admin, 'api')
             ->postJson(route('admin.projects.deny', $project), $data);

        Mail::assertSent(
            ProjectDeniedEmail::class,
            function ($mail) use ($producer) {
                return $mail->hasTo($producer->email);
            }
        );
    }
}
