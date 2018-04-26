<?php


namespace App\Services;


class SocialLinksServices
{
    /**
     * @param string $url
     *
     * @return string
     */
    public static function cleanVimeo(string $url)
    {
        $uri = preg_replace('#(http(s)?://)?(www\.)?#', '', $url);

        if (substr($uri, 0, 23) === 'player.vimeo.com/video/' && strlen($uri) > 23) {
            return 'https://' . $uri;
        }

        // invalid vimeo urls
        if (substr($uri, 0, 10) != 'vimeo.com/' || strlen($uri) <= 10) {
            return '';
        }

        // convert videos to player.vimeo.com
        if (preg_match('#^vimeo\.com/([0-9]+)/?$#', $uri, $matches)) {
            return 'https://player.vimeo.com/video/' . $matches[1];
        }

        return 'https://' . $uri;
    }
}