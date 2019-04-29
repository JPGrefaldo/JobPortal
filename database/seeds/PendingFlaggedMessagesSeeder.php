<?php

use App\Models\PendingFlagMessage;
use Illuminate\Database\Seeder;

class PendingFlaggedMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PendingFlagMessage::class, 5)->create();
    }
}
