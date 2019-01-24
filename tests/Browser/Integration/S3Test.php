<?php

namespace Tests\Browser\Integration;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class S3Test extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function can_create_read_and_delete()
    {
        // given
        $path = 'test/' . uniqid() . '.txt';
        $s3 = Storage::disk('s3');
        $sentence = $this->faker->sentence;

        // CREATE
        // when
        $s3->put($path, $sentence);

        $contents = $s3->get($path);
        // dump(config('filesystems.disks.s3.url') . '/' . config('filesystems.disks.s3.bucket') . '/' . $path);

        // READ
        // then
        $this->assertEquals($sentence, $contents);

        // DELETE
        // when
        $s3->delete($path);

        // then
        $this->assertFalse($s3->exists($path));
    }
}
