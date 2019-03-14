<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Services\SocialLinksServices;
use App\Utils\StrUtils;

class CleanVideoLink
{
    /**
     * @param $link
     * @return string
     * @throws \Exception
     */
    public function execute($link): string
    {
        if (strpos($link, 'vimeo.com') !== false) {
            $link = SocialLinksServices::cleanVimeo($link);
        } else {
            $link = StrUtils::cleanYouTube($link);
        }

        if (empty($link)) {
            throw new \Exception("Invalid video link ($link)");
        }

        return $link;
    }
}
