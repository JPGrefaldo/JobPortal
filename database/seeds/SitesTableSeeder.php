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
            'name'     => config('app.name'),
            'hostname' => UrlUtils::getHostNameFromBaseUrl(config('app.url')),
        ]);

        $this->command->info('Current site seeded');
    }
}
