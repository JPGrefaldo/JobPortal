<?php

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'name' => 'Production',
        ]);
        Department::create([
            'name' => 'Art',
        ]);
        Department::create([
            'name' => 'Camera',
        ]);
        Department::create([
            'name' => 'Grip_Electric',
        ]);
        Department::create([
            'name' => 'MUaH_Wardrobe',
        ]);
        Department::create([
            'name' => 'Sound',
        ]);
        Department::create([
            'name' => 'Other',
        ]);

        $this->command->info('Departments seeded');
    }
}
