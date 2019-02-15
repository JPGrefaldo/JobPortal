<?php

use App\Models\ProjectType;
use Illuminate\Database\Seeder;

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
        $this->command->info('Project Types seeded');
    }
}
