<?php

namespace Tests\Unit\Observers;

use App\Mail\ManagerConfirmationEmail;
use App\Mail\ManagerDeletedEmail;
use App\Models\Manager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ManagerObserverTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Observers\ManagerObserver::created
     */
    public function created()
    {
        // given
        Mail::fake();
        $manager = $this->createUser();

        // when
        factory(Manager::class)->create([
            'manager_id' => $manager->id,
        ]);

        // then
        Mail::assertSent(
            ManagerConfirmationEmail::class,
            function ($mail) use ($manager) {
                return $mail->hasTo($manager->email);
            }
        );
    }

    /**
     * @test
     * @covers \App\Observers\ManagerObserver::deleted
     */
    public function deleted()
    {
        // given
        Mail::fake();
        $manager = $this->createUser();
        $record = factory(Manager::class)->create([
            'manager_id' => $manager->id,
        ]);

        // when
        $record->delete();

        // then
        Mail::assertSent(
            ManagerDeletedEmail::class,
            function ($mail) use ($manager) {
                return $mail->hasTo($manager->email);
            }
        );
    }
}
