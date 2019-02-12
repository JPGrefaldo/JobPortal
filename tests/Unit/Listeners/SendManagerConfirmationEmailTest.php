<?php

namespace Tests\Unit\Listeners;

use App\Events\ManagerAdded;
use App\Listeners\SendManagerConfirmationEmail;
use App\Mail\ManagerConfirmationEmail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class SendManagerConfirmationEmailTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Listeners\SendManagerConfirmationEmail::handle
     */
    public function handle()
    {
        Event::fake([
            ManagerAdded::class
        ]);

        $subordinate = $this->createUser();
        $manager = $this->createUser();

        $response = $this->actingAs($subordinate)
                         ->post(route('account.manager'), [
                             'email' => $manager->email
                         ]);
        Event::assertDispatched(ManagerAdded::class);
    }
}
