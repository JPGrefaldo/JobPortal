<?php

namespace App\Actions\Crew;

use App\Actions\Social\CleanVimeoLinkAction;
use App\Actions\Social\IsVimeoPlayerUrlAction;
use App\Actions\Social\IsVimeoUrlAction;
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
        if (app(IsVimeoUrlAction::class)->execute($link) ||
            app(IsVimeoPlayerUrlAction::class)->execute($link)
        ) {
            $link = app(CleanVimeoLinkAction::class)->execute($link);
        } else {
            $link = StrUtils::cleanYouTube($link);
        }

        if (empty($link)) {
            throw new \Exception("Invalid video link ($link)");
        }

        return $link;
    }
}
