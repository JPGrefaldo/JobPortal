<?php

namespace Tests\Feature\Console;

use App\Models\Message;
use App\Models\Participant;
use App\Models\Project;
use App\Models\ProjectThread;
use App\Models\Role;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class FakeMessagesTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    const CMD = 'fake:messages';

    /**
     * @test
     * @covers \App\Console\Commands\FakeMessages::handle
     */
    public function should_create_two_new_users_when_no_sender_and_receiver_options()
    {
        $command = $this->artisan(self::CMD);
        $command->expectsOutput('Creating new 2 users with a producer and crew role respectively')
                ->run();

        $users = User::all();
        $this->assertCount(2, $users->toArray());
        $this->assertTrue($users[0]->hasRole(Role::PRODUCER));
        $this->assertTrue($users[1]->hasRole(Role::CREW));
        $this->assertArrayNotHasKey(3, $users->toArray());
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeMessages::handle
     */
    public function should_get_existing_users_when_sender_and_receiver_options_is_present()
    {
        $this->runCommand();

        $users = User::all();
        $this->assertCount(2, $users->toArray());
        $this->assertTrue($users[0]->hasRole(Role::PRODUCER));
        $this->assertTrue($users[1]->hasRole(Role::CREW));
        $this->assertArrayNotHasKey(3, $users->toArray());
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeMessages::handle
     */
    public function should_create_a_project()
    {
        $this->assertCount(0, Project::all());

        $this->runCommand();

        $this->assertCount(1, Project::all());
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeMessages::handle
     */
    public function should_create_a_thread()
    {
        $this->assertCount(0, Thread::all());

        $this->runCommand();

        $this->assertCount(1, Thread::all());
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeMessages::handle
     */
    public function should_create_a_project_thread_pivot()
    {
        $this->assertCount(0, ProjectThread::all());

        $this->runCommand();

        $this->assertCount(1, ProjectThread::all());
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeMessages::handle
     */
    public function should_create_a_project_message()
    {
        $this->assertCount(0, Message::all());

        $this->runCommand();

        $this->assertCount(2, Message::all());
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeMessages::handle
     */
    public function should_create_a_participant()
    {
        $this->assertCount(0, Participant::all());

        $this->runCommand();

        $this->assertCount(2, Participant::all());
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeMessages::handle
     */
    public function should_not_create_when_sender_is_a_crew()
    {
        $user  = $this->createParticipant('crew');
        $user2 = $this->createParticipant('crew');

        $command = $this->artisan(self::CMD." --sender={$user->id} --receiver={$user2->id}");
        $command->expectsOutput("The sender's role is {$user->getRoleNames()}, not a Producer")
                ->run();
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeMessages::handle
     */
    public function should_not_create_when_receiver_is_a_producer()
    {
        $user  = $this->createParticipant();
        $user2 = $this->createParticipant();

        $command = $this->artisan(self::CMD." --sender={$user->id} --receiver={$user2->id}");
        $command->expectsOutput("The receiver's role is {$user2->getRoleNames()}, not a Crew")
                ->run();
    }

    private function runCommand()
    {
        $sender   = $this->createParticipant();
        $receiver = $this->createParticipant('crew');

        $command = $this->artisan(self::CMD." --sender={$sender->id} --receiver={$receiver->id}");
        $command->expectsOutput('Done seeding message!')
                ->run();
    }

    private function createParticipant($role='producer')
    {
        $user = factory(User::class)->create();
        $role === 'producer' ? $user->assignRole(Role::PRODUCER):$user->assignRole(Role::CREW);
        return $user;
    }
}
