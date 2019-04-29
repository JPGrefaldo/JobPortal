<?php

use Illuminate\Database\Seeder;
use App\Models\PendingFlagMessage;
use Cmgmyr\Messenger\Models\Thread;
use Cmgmyr\Messenger\Models\Message;
use Faker\Generator as Faker;
use App\Models\Role;
use App\Models\User;

class PendingFlaggedMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        factory(PendingFlagMessage::class, 5)->create([
            'message_id' => function() {
                return factory(Message::class)->create([
                    'thread_id' => factory(Thread::class)->create(),
                    'user_id'   => factory(User::class)->create()
                ]);
            },
            'reason' => $faker->paragraph
        ]);
    }
}
