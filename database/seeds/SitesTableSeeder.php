<?php

use Illuminate\Database\Seeder;
use App\Models\Site;
use App\Utils\UrlUtils;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Site::create([
            'name' => env('APP_NAME'),
            'hostname' => UrlUtils::getHostNameFromBaseUrl(env('APP_URL'))
        ]);

        $this->command->info('Current site seeded');
    }
}
