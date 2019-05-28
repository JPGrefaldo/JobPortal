<?php

namespace App\Utils;

class UrlUtils
{
    /**
     * @param string $url
     *
     * @return string
     */
    public static function getHostNameFromBaseUrl($url)
    {
        return preg_replace(
            ['/^(http(s)?:\/\/)?(www\.)?/', '/(?:\:.+)/', '/\/?$/'],
            '',
            $url
        );
    }

    /**
     * @param \App\Models\User|null $user
     * @return string
     */
    public static function getS3Url($user = null): string
    {
        $base = config('filesystems.disks.s3.url') . '/' . config('filesystems.disks.s3.bucket') . '/';

        return (! $user) ?
            $base :
            $base . $user->hash_id . '/';
    }
}
