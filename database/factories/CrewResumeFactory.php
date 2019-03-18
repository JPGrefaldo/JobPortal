<?php

use App\Models\Crew;
use App\Models\CrewResume;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

// TODO: restructure url, must include user hash id
$factory->define(CrewResume::class, function (Faker $faker) {
    return [
        'crew_id' => factory(Crew::class),
        'path'     => 'resumes/' . $faker->uuid . '/' . $faker->sha1 . '.pdf',
        'general' => 1,
    ];
});

// TODO: restructure url, must include user hash id
$factory->state(CrewResume::class, 'Upload', function (Faker $faker) {
    return [
        'path' => function () use ($faker) {
            $tmpFile = UploadedFile::fake()->create($faker->sha1 . '.pdf');
            $path    = 'resumes/' . $faker->uuid . '/' . $tmpFile->hashName();

            Storage::put($path, file_get_contents($tmpFile));

            return $path;
        },
    ];
});
