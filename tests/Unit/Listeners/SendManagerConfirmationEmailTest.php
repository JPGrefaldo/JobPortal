<?php

namespace Tests\Unit\Listeners;

use App\Events\ManagerAdded;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
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
