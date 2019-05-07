<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use Tests\Support\Data\SocialLinkTypeID;

class StoreCrewSocials
{
    /**
     * @param \App\Models\Crew $crew
     * @param array $data
     * @throws \Exception
     */
    public function execute(Crew $crew, array $data): void
    {
        if (! isset($data['socials']) || empty($data['socials'])) {
            return;
        }

        foreach ($data['socials'] as $value) {
            $crew->socials()->where('social_link_type_id', $value['id'])->delete();

            if (! empty($value['url'])) {
                switch ($value['id']) {
                    case SocialLinkTypeID::YOUTUBE:
                    case SocialLinkTypeID::VIMEO:
                        $socialUrl = app(CleanVideoLink::class)->execute($value['url']);
                        break;
                    default:
                        $socialUrl = $value['url'];
                        break;
                }

                $crew->socials()->create([
                    'social_link_type_id' => $value['id'],
                    'url'                 => $socialUrl,
                ]);
            }
        }
    }
}
