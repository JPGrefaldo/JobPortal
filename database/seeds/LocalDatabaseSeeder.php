<?php

use Illuminate\Database\Seeder;

class LocalDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tableNames as $name) {
            if ($name == 'migrations') {
                continue;
            }
            DB::table($name)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            DatabaseSeeder::class,
            UsersTableSeeder::class,
            CrewsTableSeeder::class,
            CrewPositionsTableSeeder::class,
        ]);
    }
}
