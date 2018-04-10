<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => Role::PRODUCER]);
        Role::create(['name' => Role::CREW]);
        Role::create(['name' => Role::ADMIN]);

        $this->command->info('Role table seeded!');
    }
}
