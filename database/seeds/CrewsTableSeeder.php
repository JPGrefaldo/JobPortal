<?php

use App\Models\Crew;
use Illuminate\Database\Seeder;

class CrewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Crew::class)->create(['user_id' => 1]);
    }
}
