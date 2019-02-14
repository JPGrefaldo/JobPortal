<?php

namespace Tests\Feature\Manager;

use App\Mail\ManagerConfirmationEmail;
use App\Mail\ManagerDeletedEmail;
use App\Observers\ManagerObserver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use App\Models\Manager;

class ManagerObserverTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountManagerController::store
     */
    public function a_confirmation_email_is_sent_to_the_manager()
    {
        Mail::fake();

        $manager = $this->createUser();
        $subordinate = $this->createUser();

        $this->actingAs($subordinate)
             ->get(route('account.manager'));

        $this->actingAs($subordinate)
             ->post(route('account.manager'), [
                'email' => $manager->email
             ]);

        Mail::assertSent(ManagerConfirmationEmail::class, 
            function($mail) use ($manager) {
                return $mail->hasTo($manager->email);
            }
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Account\AccountManagerController::destroy
     */
    public function a_delete_notification_email_is_sent_to_the_manager()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $manager = $this->createUser();
        $subordinate = $this->createUser();

        $record = factory(Manager::class)->create([
            'manager_id' => $manager->id,
            'subordinate_id' => $subordinate->id
        ]);
        $record->delete();

        Mail::assertSent(ManagerDeletedEmail::class, 
            function($mail) use ($manager) {
                return $mail->hasTo($manager->email);
            }
        );
    }
}