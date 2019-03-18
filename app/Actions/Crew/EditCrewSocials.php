<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Tests\Support\Data\SocialLinkTypeID;
use App\Utils\StrUtils;
use App\Services\SocialLinksServices;

class EditCrewSocials
{
    public function execute(Crew $crew, array $data)
    {
        foreach ($data['socials'] as $key => $value) {
            $crewSocial = $crew->socials()->where('social_link_type_id', $value['id']);

            if (! $value['url']) {
                $crewSocial->delete();
                continue;
            }

            switch ($value['id']) {
                case SocialLinkTypeID::YOUTUBE:
                case SocialLinkTypeID::VIMEO:
                    $socialUrl = app(CleanVideoLink::class)->execute($value['url']);
                    break;
                default:
                    $socialUrl = $value['url'];
                    break;
            }

            $crewSocial->update([
                'url' => $socialUrl,
            ]);
        }
    }
}
