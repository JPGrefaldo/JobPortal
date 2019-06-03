<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Position;
use App\Models\User;
use App\Models\ProjectJob;
use App\Models\Project;
use App\Models\Role;
use App\Models\CrewPosition;

class FakeCrewPositionAndJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:position_jobs
                                                {--user=0 : Crew\'s User ID to show the jobs}
                                                {--jobs=5 : Open jobs to be generated}
                                                {new      : Create new user and attached jobs to show';

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
        $jobCount = (int) $options['jobs'];

        if ($userId === 0)
        {
            return $this->error('User ID is required.');
        }

        $user = User::findOrFail($userId);

        if (! $user->hasRole(Role::CREW)) {
            return $this->error("User has {$user->getRoleNames} role, not a crew.");
        }       

        $position = Position::inRandomOrder()->first();

        factory(CrewPosition::class)->create([
            'crew_id'       => $user->crew->id,
            'position_id'   => $position->id
        ]);

        factory(ProjectJob::class, $jobCount)->create([
            'position_id'   => $position->id,
            'rush_call'     => 0
        ]);

        $this->info('Done creating crew position with open jobs');
    }
}
