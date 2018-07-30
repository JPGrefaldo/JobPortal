<?php

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionsTableSeeder extends Seeder
{
    protected $departmentIds = [
        'Production'       => 1,
        'Art'              => 2,
        'Camera'           => 3,
        'Grip_Electric'    => 4,
        'MUaH_Wardrobe'    => 5,
        'Sound'            => 6,
        'Other'            => 7,



    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            'name'          => 'Set Decorator',
            'department_id' => $this->departmentIds['Art'],
            'has_many'      => 0,
            'has_gear'      => 0
        ]);
        Position::create([
            'name'          => 'Set Designer',
            'department_id' => $this->departmentIds['Art'],
            'has_many'      => 0,
            'has_gear'      => 0
        ]);
        Position::create([
            'name'          => 'Art Director/Production Designer',
            'department_id' => $this->departmentIds['Art'],
            'has_many'      => 0,
            'has_gear'      => 0
        ]);
        Position::create([
            'name'          => 'Backings & Scenic Artist',
            'department_id' => $this->departmentIds['Art'],
            'has_many'      => 0,
            'has_gear'      => 0
        ]);
        Position::create([
            'name'          => 'Prop Master',
            'department_id' => $this->departmentIds['Art'],
            'has_many'      => 0,
            'has_gear'      => 0
        ]);


        Position::create([
            'name'          => 'Camera Assistant',
            'department_id' => $this->departmentIds['Camera'],
            'has_many'      => 0,
            'has_gear'      => 1
        ]);
        Position::create([
            'name'          => 'Camera Operator',
            'department_id' => $this->departmentIds['Camera'],
            'has_many'      => 0,
            'has_gear'      => 1
        ]);
        Position::create([
            'name'          => 'Camera Operator – Aerial',
            'department_id' => $this->departmentIds['Camera'],
            'has_many'      => 0,
            'has_gear'      => 1
        ]);
        Position::create([
            'name'          => 'Camera Operator-Steadicam',
            'department_id' => $this->departmentIds['Camera'],
            'has_many'      => 0,
            'has_gear'      => 1
        ]);


        Position::create([
            'name'          => 'Gaffer',
            'department_id' => $this->departmentIds['Grip_Electric'],
            'has_many'      => 0,
            'has_gear'      => 0
        ]);
        Position::create([
            'name'          => 'Electrical Lighting Technician',
            'department_id' => $this->departmentIds['Grip_Electric'],
            'has_many'      => 0,
            'has_gear'      => 0
        ]);
        Position::create([
            'name'          => 'Generator (Genny) Operator',
            'department_id' => $this->departmentIds['Grip_Electric'],
            'has_many'      => 0,
            'has_gear'      => 1
        ]);
        Position::create([
            'name'          => 'Grip',
            'department_id' => $this->departmentIds['Grip_Electric'],
            'has_many'      => 0,
            'has_gear'      => 0
        ]);
        Position::create([
            'name'          => 'Best Boy (Gaffer)',
            'department_id' => $this->departmentIds['Grip_Electric'],
            'has_many'      => 0,
            'has_gear'      => 0
        ]);
        Position::create([
            'name'          => 'Best Boy (Grip)',
            'department_id' => $this->departmentIds['Grip_Electric'],
            'has_many'      => 0,
            'has_gear'      => 0
        ]);
        Position::create([
            'name'          => 'Key Grip',
            'department_id' => $this->departmentIds['Grip_Electric'],
            'has_many'      => 0,
            'has_gear'      => 0
        ]);
        Position::create([
            'name'          => 'Dolly Grip',
            'department_id' => $this->departmentIds['Grip_Electric'],
            'has_many'      => 0,
            'has_gear'      => 0
        ]);

        
        Position::create([
            'name'          => 'Hair & Makeup Artist (MUaH)',
            'department_id' => $this->departmentIds['MUaH_Wardrobe'],
            'has_many'      => 0,
            'has_gear'      => 1
        ]);
        Position::create([
            'name'          => 'Prosthetics/FX Makeup',
            'department_id' => $this->departmentIds['MUaH_Wardrobe'],
            'has_many'      => 0,
            'has_gear'      => 1
        ]);
        Position::create([
            'name'          => 'Wardrobe Stylists/Costume Designer',
            'department_id' => $this->departmentIds['MUaH_Wardrobe'],
            'has_many'      => 0,
            'has_gear'      => 1
        ]);


        Position::create([
            'name'          => 'Production Coordinator',
            'department_id' => $this->departmentIds['Production'],
            'has_many'      => 0,
            'has_gear'      => 0
        ]);
        Position::create([
            'name'          => 'Production Manager/Unit Production Manager',
            'department_id' => $this->departmentIds['Production'],
            'has_many'      => 0,
            'has_gear'      => 0

        ]);
        Position::create([
            'name'          => 'Digital Imaging Technician (DIT)',
            'department_id' => $this->departmentIds['Production'],
            'has_many'      => 0,
            'has_gear'      => 1
        ]);
        Position::create([
            'name'          => 'Script Supervisor',
            'department_id' => $this->departmentIds['Production'],
            'has_many'      => 0
        ]);
        Position::create([
            'name'          => 'Second Assistant Director',
            'department_id' => $this->departmentIds['Production'],
            'has_many'      => 0
        ]);
        Position::create([
            'name'          => 'Baby Wrangler',
            'department_id' => $this->departmentIds['Production'],
            'has_many'      => 0
        ]);
        Position::create([
            'name'          => 'Behind the Scenes Photographer/Videographer',
            'department_id' => $this->departmentIds['Production'],
            'has_many'      => 0,
            'has_gear'      => 1
        ]);
        Position::create([
            'name'          => 'Production Assistant',
            'department_id' => $this->departmentIds['Production'],
            'has_many'      => 0
        ]);
        Position::create([
            'name'          => 'First Assistant Director',
            'department_id' => $this->departmentIds['Production'],
            'has_many'      => 0
        ]);
        Position::create([
            'name'          => 'Choreographer',
            'department_id' => $this->departmentIds['Production'],
            'has_many'      => 0
        ]);
        Position::create([
            'name'          => 'Stunt Coordinator',
            'department_id' => $this->departmentIds['Production'],
            'has_many'      => 0
        ]);

        Position::create([
            'name'          => 'Boom Operator',
            'department_id' => $this->departmentIds['Sound'],
            'has_many'      => 0,
            'has_gear'      => 1
        ]);
        Position::create([
            'name'          => 'Audio Mixer & Assistant',
            'department_id' => $this->departmentIds['Sound'],
            'has_many'      => 0,
            'has_gear'      => 1

        ]);



    }
}
