<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SitesTableSeeder::class,
            RolesTableSeeder::class,
            SocialLinkTypesTableSeeder::class,
            PositionTypeTableSeeder::class,
            DepartmentsTableSeeder::class,
            PositionsTableSeeder::class,
            ProjectTypesTableSeeder::class,
            PayTypesTableSeeder::class
        ]);
    }
}
