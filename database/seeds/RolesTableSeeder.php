<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

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
        Role::create(['name' => Role::MANAGER]);

        $this->command->info('Role table seeded!');
    }
}
