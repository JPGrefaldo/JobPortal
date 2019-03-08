<?php

use App\Models\Project;
use App\Models\Site;
use App\Models\User;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Seeder;

class MessengerDashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        $projects = factory(Project::class, 2)->create([
            'user_id' => $user->id,
        ]);

        foreach ($projects as $project) {
            $threads = factory(Thread::class, 2)->create();

            $project->threads()->saveMany($threads);

            foreach ($threads as $thread) {
                $thread->addParticipant($user->id);

                $message = factory(Message::class)->create([
                    'user_id' => $user->id,
                ]);

                $thread->messages()->save($message);

                $message = factory(Message::class)->create();

                $thread->messages()->save($message);
                $thread->addParticipant($message->user_id);
            };
        };

        $crew = $user->crew;
        $projects = factory(Project::class, 2)->create();

        $crew->projects()->attach($projects);

        foreach ($projects as $project) {
            $threads = factory(Thread::class, 2)->create();

            $project->threads()->saveMany($threads);

            foreach ($threads as $thread) {
                $thread->addParticipant($user->id);

                $message = factory(Message::class)->create([
                    'user_id' => $project->user_id,
                ]);

                $thread->messages()->save($message);

                $message = factory(Message::class)->create([
                    'user_id' => $crew->user->id,
                ]);

                $thread->messages()->save($message);
                $thread->addParticipant($message->user_id);
            }
        }
    }
}
