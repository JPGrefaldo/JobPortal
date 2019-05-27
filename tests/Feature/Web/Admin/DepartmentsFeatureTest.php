<?php

namespace Tests\Feature\Admin\Web;

use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class DepartmentsFeatureTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\DepartmentController::index
     */
    public function index()
    {
        $admin = $this->createAdmin();
        $departments = Department::all();

        $response = $this->actingAs($admin, 'api')
            ->getJson(route('admin.departments'));

        $response->assertJson($departments->toArray());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\DepartmentController::store
     */
    public function create()
    {
        $user = $this->createAdmin();
        $data = [
            'name'        => 'Lighting',
            'description' => 'Some Description',
        ];

        $response = $this->actingAs($user, 'api')
            ->post(route('admin.departments', $data));

        $response->assertSuccessful();

        $this->assertDatabaseHas('departments', [
            'name'        => 'Lighting',
            'description' => 'Some Description',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\DepartmentController::store
     */
    public function create_no_description()
    {
        $user = $this->createAdmin();
        $data = [
            'name'        => 'Lighting',
            'description' => '',
        ];

        $response = $this->actingAs($user, 'api')
            ->post(route('admin.departments', $data));

        $response->assertSuccessful();

        $this->assertDatabaseHas('departments', [
            'name'        => 'Lighting',
            'description' => '',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\DepartmentController::store
     */
    public function create_formatted_name()
    {
        $user = $this->createAdmin();
        $data = [
            'name'        => 'Production sound',
            'description' => 'Some description',
        ];

        $response = $this->actingAs($user, 'api')
            ->post(route('admin.departments', $data));

        $response->assertSuccessful();

        // assert that name is formatted
        $department = Department::whereName('Production sound')
            ->first();

        $this->assertEquals('Production Sound', $department->name);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\DepartmentController::store
     */
    public function create_invalid_data()
    {
        $user = $this->createAdmin();
        $data = [
            'name'        => '',
            'description' => '',
        ];

        $response = $this->actingAs($user, 'api')
            ->post(route('admin.departments', $data));

        $response->assertSessionHasErrors([
            'name' => 'The name field is required.',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\DepartmentController::store
     */
    public function create_duplicate_name()
    {
        factory(Department::class)->create(['name' => 'Lighting']);

        $user = $this->createAdmin();
        $data = [
            'name'        => 'lighting',
            'description' => '',
        ];

        $response = $this->actingAs($user, 'api')
            ->post(route('admin.departments', $data));

        $response->assertSessionHasErrors([
            'name' => 'The name has already been taken.',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\DepartmentController::update
     */
    public function update()
    {
        $user       = $this->createAdmin();
        $department = factory(Department::class)->create();
        $data       = [
            'name'        => 'New Name',
            'description' => 'New Description',
        ];

        $response = $this->actingAs($user, 'api')
            ->put(route('admin.departments.update', ['department' => $department->id]), $data);

        $response->assertSuccessful();

        $this->assertArrayHas(
            [
                'name'        => 'New Name',
                'description' => 'New Description',
            ],
            $department->refresh()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\DepartmentController::update
     */
    public function update_no_description()
    {
        $user       = $this->createAdmin();
        $department = factory(Department::class)->create();
        $data       = [
            'name'        => 'New Name',
            'description' => '',
        ];

        $response = $this->actingAs($user, 'api')
            ->put(route('admin.departments.update', ['department' => $department->id]), $data);

        $response->assertSuccessful();

        $this->assertArrayHas(
            [
                'name'        => 'New Name',
                'description' => '',
            ],
            $department->refresh()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\DepartmentController::update
     */
    public function update_formatted_name()
    {
        $user       = $this->createAdmin();
        $department = factory(Department::class)->create();
        $data       = [
            'name'        => 'new name',
            'description' => '',
        ];

        $response = $this->actingAs($user, 'api')
            ->put(route('admin.departments.update', ['department' => $department->id]), $data);

        $response->assertSuccessful();

        $this->assertArrayHas(
            [
                'name'        => 'New Name',
                'description' => '',
            ],
            $department->refresh()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\DepartmentController::update
     */
    public function update_same()
    {
        $user       = $this->createAdmin();
        $data       = [
            'name'        => 'Same Name',
            'description' => 'Same Description',
        ];
        $department = factory(Department::class)->create($data);

        $response = $this->actingAs($user, 'api')
            ->put(route('admin.departments.update', ['department' => $department->id]), $data);

        $response->assertSuccessful();

        $this->assertArrayHas(
            [
                'name'        => 'Same Name',
                'description' => 'Same Description',
            ],
            $department->refresh()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\DepartmentController::update
     */
    public function update_invalid_data()
    {
        $user       = $this->createAdmin();
        $department = factory(Department::class)->create();
        $data       = [
            'name'        => '',
            'description' => '',
        ];

        $response = $this->actingAs($user, 'api')
            ->put(route('admin.departments.update', ['department' => $department->id]), $data);

        $response->assertSessionHasErrors([
            'name' => 'The name field is required.',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\DepartmentController::update
     */
    public function update_duplicate_name()
    {
        factory(Department::class)->create(['name' => 'Lighting']);

        $user       = $this->createAdmin();
        $department = factory(Department::class)->create();
        $data       = [
            'name'        => 'lighting',
            'description' => '',
        ];

        $response = $this->actingAs($user, 'api')
            ->put(route('admin.departments.update', ['department' => $department->id]), $data);

        $response->assertSessionHasErrors([
            'name' => 'The name has already been taken.',
        ]);
    }
}
