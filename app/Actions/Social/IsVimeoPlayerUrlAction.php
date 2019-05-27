<?php

namespace App\Actions\Social;

use App\Utils\StrUtils;

class IsVimeoPlayerUrlAction
{
    /**
     * @param $url
     * @return bool
     */
    public function execute($url): bool
    {
        $url = StrUtils::stripHTTPS($url);

        return (substr($url, 0, 23) === 'player.vimeo.com/video/' && strlen($url) > 23);
    }
}
