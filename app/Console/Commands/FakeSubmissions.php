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
    protected $signature = 'fake:submissions {new=true}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed fake data of projects with jobs(roles)';

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
        $new = $this->argument('new');

        if ($new === 'true') {
            $this->info('Creating submissions from 10 new users with crew role');
            $crews = $this->create_new_users();
        } else {
            $this->info('Creating submissions from existing users with crew role');
            $crews = $this->get_existing_users();

            if (! isset($crews) || count($crews) === 0) {
                $this->info('No users found with crew role, creating submissions from 10 new users with crew role instead');
                $crews = $this->create_new_users();
            }
        }

        $producer   = factory(User::class)->create();
        $producer->assignRole(Role::PRODUCER);

        $project = factory(Project::class)->create([
            'user_id' => $producer->id
        ]);
        
        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id
        ]);

        $crews->map(function($crew) use($new, $projectJob) {
            if ($new === 'true') {
                $crew->assignRole(Role::CREW);
                app(StubCrew::class)->execute($crew);
            }

            factory(Submission::class)->create(
                [
                    'crew_id'           => $crew->id,
                    'project_job_id'    => $projectJob->id
                ]
            );
        });

        $this->info('Done creating submissions');
    }

    private function create_new_users()
    {
        return factory(User::class, 10)->create();
    }

    private function get_existing_users()
    {
        return User::role(Role::CREW)->get();
    }
}
