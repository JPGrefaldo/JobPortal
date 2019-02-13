<?php

namespace Tests\Unit\Listeners;

use App\Events\ManagerDeleted;
use App\Models\Manager;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class SendManagerDeletedEmailTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Listeners\SendManagerDeletedEmail::handle
     */
    public function handle()
    {
        $this->disableExceptionHandling();

        $manager = $this->createUser();
        $subordinate = $this->createUser();

        $this->actingAs($subordinate)
             ->post(route('account.manager'), [
                'email' => $manager->email
             ]);

        Event::fake([
            ManagerDeleted::class
        ]);

        $response = $this->actingAs($subordinate)
                         ->call('DELETE', route('manager.remove', [
                            'manager' => $manager->id
                         ]));

        // $response->assertRedirect(route('account.manager'));

        Event::assertDispatched(ManagerDeleted::class);
    }
}
