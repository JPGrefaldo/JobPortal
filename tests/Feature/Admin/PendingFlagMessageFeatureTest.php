<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Illuminate\Http\Response;

class PendingFlagMessageFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function test_only_admin_can_see_pending_flag_messages()
    {
        factory(\App\Models\PendingFlagMessage::class)->create([
            'approved_at'    => null,
            'disapproved_at' => null
        ]);

        factory(\App\Models\PendingFlagMessage::class)->create([
            'approved_at'    => \Carbon\Carbon::now(),
            'disapproved_at' => null
        ]);

        factory(\App\Models\PendingFlagMessage::class)->create([
            'approved_at'    => null,
            'disapproved_at' => \Carbon\Carbon::now()
        ]);
        
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->get(route('admin.flag-messages.index'))
            ->assertSuccessful();

        $this->actingAs($admin)
            ->get('api/admin/flag-messages')
            ->assertSuccessful();
    }

    public function test_crew_is_not_allowed_to_see_flag_messages()
    {
        $crew = $this->createCrew();

        $this->actingAs($crew)
            ->get(route('admin.flag-messages.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->actingAs($crew)
            ->get('api/admin/flag-messages')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_producer_is_not_allowed_to_see_flag_messages()
    {
        $producer = $this->createProducer();

        $this->actingAs($producer)
            ->get(route('admin.flag-messages.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);

        $this->actingAs($producer)
            ->get('api/admin/flag-messages')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
