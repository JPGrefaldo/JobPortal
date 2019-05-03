<?php

namespace App\Console\Commands;

use App\Actions\Crew\StubCrew;
use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\Role;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Console\Command;

class FakeSubmissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:submissions
                                            {--new      : Create submission with new users}
                                            {--users=10 : Users count to be created}
                                            {--multiple : Create multiple submission on a job}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed fake submissions of a project job';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $options = $this->options();
        $users   = $options['users'];

        $producer = factory(User::class)->create();
        $producer->assignRole(Role::PRODUCER);

        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        if ($options['new']) {
            $this->info('Creating submissions with '.$users.' new users with crew role');
            $users = $this->createUsers($users);
        } else {
            $this->info('Creating submissions from existing users with crew role');
            $users = $this->getExistingUsers();

            if (! isset($crews) || count($crews) === 0) {
                $this->info('No existing users found with crew role, creating submissions with 10 new users with crew role instead');
                $users = $this->createUsers($users);
            }
        }

        $projectJobs = $options['multiple'] 
                     ? $this->createProjectJob($project, 3) 
                     : $this->createProjectJob($project);

        $users->map(function ($user) use ($options, $project, $projectJobs) {
            if ($options['new']) {
                $user->assignRole(Role::CREW);
                app(StubCrew::class)->execute($user);
            }

            $projectJobs->map(function($job) use($user, $project){
                $this->createSubmission($user, $project, $job);
            });
        });

        $this->info('Done creating submissions');
    }

    private function createUsers($users)
    {
        return factory(User::class, (int)$users)->create();
    }

    private function getExistingUsers()
    {
        return User::role(Role::CREW)->get();
    }

    private function createSubmission($user, $project, $projectJob)
    {
        factory(Submission::class)->create(
            [
                'crew_id'          => $user->crew->id,
                'project_id'       => $project->id,
                'project_job_id'   => $projectJob->id,
            ]
        );
    }

    private function createProjectJob($project, $count=1)
    {
        return factory(ProjectJob::class, $count)->create([
            'project_id' => $project->id,
        ]);
    }
}
