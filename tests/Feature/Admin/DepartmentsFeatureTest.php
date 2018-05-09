<?php

namespace Tests\Feature\Admin;

use App\Models\Department;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartmentsFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /** @test */
    public function test_create()
    {
        $user = $this->createAdmin();
        $data = [
            'name'        => 'Lighting',
            'description' => 'Some Description',
        ];

        $response = $this->actingAs($user)->post('/admin/departments', $data);

        $response->assertSuccessful();

        $this->assertDatabaseHas('departments', [
            'name'        => 'Lighting',
            'description' => 'Some Description',
        ]);
    }

    /** @test */
    public function test_create_no_description()
    {
        $user = $this->createAdmin();
        $data = [
            'name'        => 'Lighting',
            'description' => '',
        ];

        $response = $this->actingAs($user)->post('/admin/departments', $data);

        $response->assertSuccessful();

        $this->assertDatabaseHas('departments', [
            'name'        => 'Lighting',
            'description' => '',
        ]);
    }

    /** @test */
    public function test_create_formatted_name()
    {
        $user = $this->createAdmin();
        $data = [
            'name'        => 'Production sound',
            'description' => 'Some description',
        ];

        $response = $this->actingAs($user)->post('/admin/departments', $data);

        $response->assertSuccessful();

        // assert that name is formatted
        $department = Department::whereName('Production sound')->first();

        $this->assertEquals('Production Sound', $department->name);
    }

    /** @test */
    public function test_create_invalid_data()
    {
        $user = $this->createAdmin();
        $data = [
            'name'        => '',
            'description' => '',
        ];

        $response = $this->actingAs($user)->post('/admin/departments', $data);

        $response->assertSessionHasErrors([
            'name' => 'The name field is required.'
        ]);
    }

    /** @test */
    public function test_create_duplicate_name()
    {
        $user = $this->createAdmin();

        factory(Department::class)->create(['name' => 'Lighting']);

        $data = [
            'name'        => 'lighting',
            'description' => '',
        ];

        $response = $this->actingAs($user)->post('/admin/departments', $data);

        $response->assertSessionHasErrors([
            'name' => 'The name has already been taken.'
        ]);
    }
}
