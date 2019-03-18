<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\CrewSocial;
use Tests\Support\Data\SocialLinkTypeID;

class SaveCrewSocials
{
    public function execute(Crew $crew, array $data)
    {
        foreach ($data['socials'] as $key => $value) {
            if (! $value['url']) {
                continue;
            }

            if ($value['id'] === SocialLinkTypeID::YOUTUBE || $value['id'] === SocialLinkTypeID::VIMEO) {
                $socialUrl = app(CleanVideoLink::class)->execute($value['url']);
            } else {
                $socialUrl = $value['url'];
            }

            $crew->socials()->save(new CrewSocial([
                'social_link_type_id' => $value['id'],
                'url'                 => $socialUrl,
            ]));
        }
    }
}
