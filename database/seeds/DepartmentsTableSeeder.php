<?php

use Illuminate\Database\Seeder;
use App\Models\Department;

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
            'name' => 'Production'
        ]);
        Department::create([
            'name' => 'Art'
        ]);
        Department::create([
            'name' => 'Camera'
        ]);
        Department::create([
            'name' => 'Grip_Electric'
        ]);
        Department::create([
            'name' => 'MUaH_Wardrobe'
        ]);
        Department::create([
            'name' => 'Sound'
        ]);
        Department::create([
            'name' => 'Other'
        ]);

    }
}
