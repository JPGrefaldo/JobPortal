<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Tests\Support\Data\SocialLinkTypeID;

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

            if ($crewSocial->count()) {
                $crewSocial->update([
                    'url' => $socialUrl,
                ]);
            } else {
                $crewSocial->insert([
                    'crew_id'             => $crew->id,
                    'social_link_type_id' => $value['id'],
                    'url'                 => $socialUrl,
                ]);
            }
        }
    }
}
