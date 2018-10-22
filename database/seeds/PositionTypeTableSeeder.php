<?php

use App\Models\PositionTypes;
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
        PositionTypes::create([
            'name' => 'Above the Line',
        ]);
        PositionTypes::create([
            'name' => 'Pre-Production',
        ]);
        PositionTypes::create([
            'name' => 'On-Set Positions',
        ]);
        PositionTypes::create([
            'name' => 'Post-Production',
        ]);

        $this->command->info('Department Types seeded');
    }
}
