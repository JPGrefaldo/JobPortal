<?php

namespace App\Actions\Social;

use App\Utils\StrUtils;

class IsVimeoUrlAction
{
    /**
     * @param $url
     * @return bool
     */
    public function execute($url): bool
    {
        $url = StrUtils::stripHTTPS($url);

        return (substr($url, 0, 10) === 'vimeo.com/' && strlen($url) > 10);
    }
}
