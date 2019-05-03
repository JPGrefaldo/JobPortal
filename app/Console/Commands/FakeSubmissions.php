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
                                            {--new=false : Create submission with new users}
                                            {--users=10  : Users count to be created}';

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

        if ($options['new'] == 'true') {
            $this->info('Creating submissions from '.$users.' new users with crew role');
            $crews = $this->createUsers($users);
        } else {
            $this->info('Creating submissions from existing users with crew role');
            $crews = $this->getExistingUsers();

            if (! isset($crews) || count($crews) === 0) {
                $this->info('No existing users found with crew role, creating submissions from default 10 new users with crew role instead');
                $crews = $this->createUsers($users);
            }
        }

        $producer = factory(User::class)->create();
        $producer->assignRole(Role::PRODUCER);

        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id,
        ]);

        $crews->map(function ($crew) use ($options, $project, $projectJob) {
            if ($options['new'] == 'true') {
                $crew->assignRole(Role::CREW);
                app(StubCrew::class)->execute($crew);
            }

            factory(Submission::class)->create(
                [
                    'crew_id'           => $crew->id,
                    'project_id'        => $project->id,
                    'project_job_id'    => $projectJob->id,
                ]
            );
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
}
