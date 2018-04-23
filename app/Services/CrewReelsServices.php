<?php


namespace App\Services;




use App\Models\CrewReel;
use App\Utils\StrUtils;

class CrewReelsServices
{
    public function create(array $data)
    {
        return CrewReel::create($this->prepareData($data));
    }

    public function createGeneral(array $data)
    {
        $data['general'] = 1;

        return $this->create($data);
    }

    private function prepareData(array $data)
    {
        $data['url'] = $this->cleanUrl($data['url']);

        return $data;
    }

    /**
     * Clean youtube or vimeo URL
     *
     * @param string $url
     *
     * @return string
     */
    public static function cleanUrl(string $url)
    {
        $youtubeUrl = StrUtils::cleanYouTube($url);

        if (parse_url($youtubeUrl, PHP_URL_HOST) === 'www.youtube.com') {
            return $youtubeUrl;
        }

        return SocialLinksServices::cleanVimeo($url);
    }
}