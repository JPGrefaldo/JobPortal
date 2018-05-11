<?php

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionsTableSeeder extends Seeder
{
    protected $departmentIds = [
        'Production' => 1,
        'Camera'     => 2,
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            'name'          => '1st Assistant Director',
            'department_id' => $this->departmentIds['Production'],
        ]);
        Position::create([
            'name'          => 'Camera Operator',
            'department_id' => $this->departmentIds['Camera'],
            'has_gear'      => 1,
        ]);
    }
}
