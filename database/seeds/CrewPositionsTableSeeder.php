<?php

use App\Models\CrewPosition;
use Illuminate\Database\Seeder;

class CrewPositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CrewPosition::class)->create(['crew_id' => 1]);
    }
}
