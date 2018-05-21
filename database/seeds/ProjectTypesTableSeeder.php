<?php

use Illuminate\Database\Seeder;
use App\Models\ProjectType;

class ProjectTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectType::create([
            'name' => 'TV'
        ]);
        ProjectType::create([
            'name' => 'Film'
        ]);
        ProjectType::create([
            'name' => 'Commercial'
        ]);
        ProjectType::create([
            'name' => 'Web'
        ]);
        ProjectType::create([
            'name' => 'Live Event/Production'
        ]);
    }
}
