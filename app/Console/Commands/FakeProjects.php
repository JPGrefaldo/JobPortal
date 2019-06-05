<?php

namespace App\Console\Commands;

use App\Models\PayType;
use App\Models\Position;
use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\ProjectType;
use App\Models\Role;
use App\Models\User;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Console\Command;

class FakeProjects extends Command
{
    /**
     * @var Generator
     */
    public $faker;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:projects 
                            {number=random : Total number of projects (random = 5-15)}
                            {user=1 : User ID}
                            {approved=true }
                            {status=1 }
                            {jobs=random : Number of jobs per project (0 for no jobs) }
                           ';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fake Projects';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->faker = Factory::create();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws Exception
     */
    public function handle()
    {
        $user = User::findOrFail((int) $this->argument('user'));

        if (! $user->hasRole(Role::PRODUCER)) {
            $this->error('User is ' . $user->getRoleNames() . ' not a Producer');
            return;
        }

        $number = $this->getNumber();
        $approved = (bool) $this->argument('approved');
        $status = (int) $this->argument('status');
        $jobs = (bool) $this->argument('jobs');

        $projectTypeCount = ProjectType::count();

        for ($i = 1; $i <= $number; $i++) {
            $projects[] = factory(Project::class)->create([
                'project_type_id' => rand(1, $projectTypeCount),
                'user_id'         => $user->id,
                'site_id'         => 1,
                'status'          => $status,
                'approved_at'     => ($approved) ? now() : null,
            ]);
        }

        if ($jobs !== 0) {
            $this->createJobs($projects, $jobs, $status);
        }

        $this->info('Projects created.');
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        $number = $this->argument('number');

        if ($number == 'random') {
            return rand(5, 15);
        }

        return (int) $number;
    }

    /**
     * @param array $projects
     * @param bool $jobs
     * @param int $status
     */
    private function createJobs(array $projects, bool $jobs, int $status): void
    {
        $positions = Position::get();
        $paytype = PayType::get();

        foreach ($projects as $project) {
            if ($jobs == 'random') {
                $jobCount = rand(1, 10);
            } else {
                $jobCount = (int) $jobs;
            }

            for ($i = 1; $i <= $jobCount; $i++) {
                $job = factory(ProjectJob::class)->create([
                    'status'      => $status,
                    'project_id'  => $project->id,
                    'position_id' => $positions->random()->id,
                    'pay_type_id' => $paytype->random()->id,
                ]);
            }
        }
    }
}
