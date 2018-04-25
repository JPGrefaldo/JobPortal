<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => Role::ADMIN]);
        Role::create(['name' => Role::PRODUCER]);
        Role::create(['name' => Role::CREW]);

        $this->command->info('Role table seeded!');
    }
}
