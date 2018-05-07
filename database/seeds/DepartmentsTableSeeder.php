<?php

use Illuminate\Database\Seeder;
use App\Models\Departments;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departments::create([
            'name' => 'Production'
        ]);
        Departments::create([
            'name' => 'Camera'
        ]);
    }
}
