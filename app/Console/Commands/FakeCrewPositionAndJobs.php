<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Position;
use App\Models\User;
use App\Models\ProjectJob;
use App\Models\Project;
use App\Models\Role;
use App\Models\CrewPosition;
use App\Models\CrewIgnoredJobs;
use App\Models\Submission;

class FakeCrewPositionAndJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:position_jobs
                                                {--user=0   : Crew\'s User ID to show the jobs}
                                                {--pj=4     : Project with Job count to be generated}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed open jobs based on a crew\'s position';

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
        $options  = $this->options();
        $userId   = (int) $options['user'];
        $count = (int) $options['pj'];

        if ($userId <= 0) {
            return $this->error('User ID is required.');
        }

        if (empty($user = User::find($userId))) {
            return $this->error("User with an ID of {$userId} was not found.");
        }

        if (! $user->hasRole(Role::CREW)) {
            return $this->error("User has {$user->getRoleNames} role, not a crew.");
        }

        $position = $this->createCrewPosition($user->crew->id);
        $params   = [
            'position'  => $position->id, 
            'count'     => $count, 
            'crew'      => $user->crew->id
        ];

        $this->info('Seeding open, applied and ignored jobs...');
        $this->seedOpenJobs($params);
        $this->seedAppliedJobs($params);
        $this->seedIgnoredJobs($params);

        $this->info('Done creating crew position with open jobs');
    }

    private function seedOpenJobs($params)
    {
        $projects = $this->createProject($params['count']);
        $projects->map(function($project) use($params){
            $params['project'] = $project->id;
            $this->createJob($params, 'Open Job');
        });
    }

    private function seedAppliedJobs($params)
    {
        $projects = $this->createProject($params['count']);
        $projects->map(function($project) use($params){
            $params['project'] = $project->id;

            $job = $this->createJob($params, 'Applied Job');
            $this->createSubmission($params['crew'], $params['project'], $job);
        });
    }

    private function seedIgnoredJobs($params)
    {
        $projects = $this->createProject($params['count']);
        $projects->map(function($project) use($params){
            $params['project'] = $project->id;
            
            $job = $this->createJob($params, 'Ignored Job');
            $this->createIgnoredJobs($params['crew'], $job->id);
        });
    }

    private function createCrewPosition($crewId)
    {
        $position = Position::inRandomOrder()->first();
        factory(CrewPosition::class)->create([
            'crew_id'       => $crewId,
            'position_id'   => $position->id
        ]);

        return $position;
    }

    private function createProject($count)
    {
        return factory(Project::class, $count)->create([
            'site_id' => 1
        ]);
    }

    private function createJob($params, $note)
    {
        $job = factory(ProjectJob::class)->create([
            'position_id'   => $params['position'],
            'rush_call'     => 0,
            'project_id'    => $params['project'],
            'pay_type_id'   => rand(1,3),
            'notes'         => $note
        ]);

        return $job;
    }

    private function createSubmission($crewId, $projectId, $jobId)
    {
        factory(Submission::class)->create(
            [
                'crew_id'          => $crewId,
                'project_id'       => $projectId,
                'project_job_id'   => $jobId
            ]
        );
    }

    private function createIgnoredJobs($crewId, $jobId)
    {
        factory(CrewIgnoredJobs::class)->create([
            'crew_id'     => $crewId,
            'project_job_id' => $jobId
        ]);
    }
}
