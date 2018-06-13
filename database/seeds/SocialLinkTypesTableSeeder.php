<?php

use Illuminate\Database\Seeder;
use App\Models\SocialLinkType;

class SocialLinkTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Facebook',
            'Twitter',
            'Youtube',
            'Google Plus',
            'IMDB',
            'Tumblr',
            'Vimeo',
            'Instagram',
            'Personal Website'
        ];

        foreach ($names as $idx => $name) {
            SocialLinkType::create([
                'name' => $name,
                'image' => 'images/social/' . str_slug($name) . '.png', // @temp
                'sort_order' => $idx + 1
            ]);
        }

        $this->command->info('Social Link Types seeded');
    }
}