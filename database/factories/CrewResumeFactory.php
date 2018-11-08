<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CrewResume::class, function (Faker $faker) {
    return [
        'crew_id' => function () {
            return factory(\App\Models\Crew::class)->create()->id;
        },
        'url'     => 'resumes/' . $faker->uuid . '/' . $faker->sha1 . '.pdf',
        'general' => 1,
    ];
});

$factory->state(App\Models\CrewResume::class, 'Upload', function (Faker $faker) {
    return [
        'url' => function () use ($faker) {
            $tmpFile = \Illuminate\Http\UploadedFile::fake()->create($faker->sha1 . '.pdf');
            $path    = 'resumes/' . $faker->uuid . '/' . $tmpFile->hashName();

            Storage::put($path, file_get_contents($tmpFile));

            return $path;
        },
    ];
});
