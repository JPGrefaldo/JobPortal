<?php

namespace App\Actions\Social;

use App\Utils\StrUtils;

class CleanVimeoLinkAction
{
    /**
     * @param $url
     * @return string
     * @throws \Exception
     */
    public function execute($url): string
    {
        $uri = StrUtils::stripHTTPS($url);

        if (app(IsVimeoPlayerUrlAction::class)->execute($uri)) {
            return 'https://' . $uri;
        }

        if (! app(IsVimeoUrlAction::class)->execute($uri)) {
            return '';
        }

        // convert videos to player.vimeo.com
        if (preg_match('#^vimeo\.com/([0-9]+)/?$#', $uri, $matches)) {
            return 'https://player.vimeo.com/video/' . $matches[1];
        }

        throw new \Exception("Invalid link ($url)");
    }
}
