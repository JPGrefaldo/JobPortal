<?php

namespace Tests\Unit\Utils;

use App\Models\User;
use App\Utils\UrlUtils;
use Tests\TestCase;

class UrlUtilsTest extends TestCase
{
    /**
     * @test
     * @covers \App\Utils\UrlUtils::getHostNameFromBaseUrl
     */
    public function get_host_name_from_base_url()
    {
        $this->assertEquals(
            'dev-crewcalls.test',
            UrlUtils::getHostNameFromBaseUrl('http://dev-crewcalls.test')
        );

        $this->assertEquals(
            'dev-crewcalls.test',
            UrlUtils::getHostNameFromBaseUrl('www.dev-crewcalls.test')
        );

        $this->assertEquals(
            'dev-crewcalls.test',
            UrlUtils::getHostNameFromBaseUrl('www.dev-crewcalls.test/')
        );

        $this->assertEquals(
            'localhost',
            UrlUtils::getHostNameFromBaseUrl('localhost:8000')
        );
    }

    /**
     * @test
     * @covers \App\Utils\UrlUtils::getS3Url
     */
    public function get_s3_path()
    {
        $user = factory(User::class)->make([
            'hash_id' => rand(1000, 9999),
        ]);

        $this->assertEquals(
            config('filesystems.disks.s3.url') . '/' . config('filesystems.disks.s3.bucket') . '/',
            UrlUtils::getS3Url()
        );

        $this->assertEquals(
            config('filesystems.disks.s3.url') . '/' .
            config('filesystems.disks.s3.bucket') . '/' .
            $user->hash_id . '/',
            UrlUtils::getS3Url($user)
        );

    }
}
