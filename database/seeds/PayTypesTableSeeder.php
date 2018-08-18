<?php

use App\Models\PayType;
use Illuminate\Database\Seeder;

class PayTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PayType::create([
            'name'     => 'Per hour',
            'has_rate' => 1,
        ]);
        PayType::create([
            'name'     => 'Per day',
            'has_rate' => 1,
        ]);
        PayType::create([
            'name'     => 'Per half day',
            'has_rate' => 1,
        ]);
        PayType::create([
            'name' => 'DOE',
        ]);
        PayType::create([
            'name' => 'TBD',
        ]);
        PayType::create([
            'name' => 'Unpaid/Volunteer',
        ]);
        $this->command->info('Pay Types seeded');
    }
}
