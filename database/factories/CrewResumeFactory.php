<?php

use App\Models\Crew;
use App\Models\CrewResume;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

/** @var $factory \Illuminate\Database\Eloquent\Factory */

// TODO: restructure url, must include user hash id
$factory->define(CrewResume::class, function (Faker $faker) {
    return [
        'crew_id'  => factory(Crew::class),
        'path'     => $faker->uuid . '/resumes/' . $faker->sha1 . '.pdf',
        'general'  => 1,
    ];
});

// TODO: restructure url, must include user hash id
$factory->state(CrewResume::class, 'Upload', function (Faker $faker) {
    return [
        'path' => function () use ($faker) {
            return UploadedFile::fake()->create($faker->sha1 . '.pdf')->store(
                $faker->uuid . '/resumes',
                's3',
                'public'
            );
        },
    ];
});
