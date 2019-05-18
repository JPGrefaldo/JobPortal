<?php

use App\Models\PositionType;
use Illuminate\Database\Seeder;

class PositionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PositionType::create([
            'name' => 'Above the Line',
        ]);
        PositionType::create([
            'name' => 'Pre-Production',
        ]);
        PositionType::create([
            'name' => 'On-Set Positions',
        ]);
        PositionType::create([
            'name' => 'Post-Production',
        ]);

        $this->command->info('Department Types seeded');
    }
}
