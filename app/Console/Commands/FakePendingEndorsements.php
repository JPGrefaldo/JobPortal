<?php

namespace App\Console\Commands;

use App\Models\CrewPosition;
use App\Models\EndorsementRequest;
use App\Models\Position;
use App\Models\User;
use Illuminate\Console\Command;

class FakePendingEndorsements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:endorsement_requests 
                            {number=5 : Total number of endorsement requests}
                            {user=1 : User ID}
                            {position=random : Position ID}
                            {create_position=1 : Create crew position link if user does not have it (1 | 0)}
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fake Pending Endorsements';

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
     * @throws \Exception
     */
    public function handle()
    {
        $faker = \Faker\Factory::create();

        $total = (int) $this->argument('number');
        $bar = $this->output->createProgressBar($total + 1);

        $user = User::findOrFail((int) $this->argument('user'));

        if (! $user->hasRole('Crew')) {
            throw new \Exception('User is not Crew');
        }

        $positions = $this->getPositions();

        $userPositions = CrewPosition::select(['position_id'])
            ->whereCrewId($user->crew->id)
            ->get();

        for ($i = 0; $i <= $total; $i++) {
            if ($positions->count() > 1) {
                if (isset($positions[$i])) {
                    $position = $positions[$i];
                } else {
                    $position = $positions->random();
                }
            } else {
                $position = $positions->first();
            }

            if (! $userPositions->where('position_id', $position->id)->count()) {
                if ((bool) $this->argument('create_position')) {
                    CrewPosition::create([
                        'crew_id'           => $user->crew->id,
                        'position_id'       => $position->id,
                        'details'           => 'Faked it',
                        'union_description' => 'None',
                    ]);
                } else {
                    throw new \Exception("User does not have position ($position->id)");
                }
            }

            $bar->advance();

            $request = $user->crew->endorsementRequests()->create([
                'crew_position_id' => $position->id,
                'token' => EndorsementRequest::generateToken(),
            ]);

            $user->crew->endorsements()->create([
                'endorsement_request_id' => $request->id,
                'endorser_name' => $faker->name,
                'endorser_email' => $faker->email,
            ]);
        }

        $bar->finish();
    }

    public function getPositions()
    {
        $position = $this->argument('position');

        return ($position == 'random') ?
            Position::inRandomOrder()->get() :
            collect([Position::findOrFail($position)]);
    }
}
