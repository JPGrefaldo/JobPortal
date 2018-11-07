<?php

use App\Models\Site;
use App\Utils\UrlUtils;
use Illuminate\Database\Seeder;

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

        factory(Site::class, 5)->create();

        $this->command->info('Current site seeded');
    }
}
