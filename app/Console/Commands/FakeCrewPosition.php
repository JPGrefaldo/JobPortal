<?php

namespace App\Console\Commands;

use App\Models\CrewPosition;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;

class FakeCrewPosition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:crew_position 
                            {position=random : Position ID}
                            {user=1 : User ID}
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fake Crew Position';

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
     * @throws Exception
     */
    public function handle()
    {
        $user = User::findOrFail((int) $this->argument('user'));

        if (! $user->hasRole(Role::CREW)) {
            $this->error('User is ' . $user->getRoleNames() . ' not a Crew');
            return;
        }

        $position = $this->argument('position');

        if ($position == 'random') {
            $position = Position::inRandomOrder()->get()->first();
        } else {
            $position = Position::findOrFail($position);
        }

        CrewPosition::create([
            'crew_id'           => $user->crew->id,
            'position_id'       => $position->id,
            'details'           => 'Faked it',
            'union_description' => 'None',
        ]);
    }
}
