<?php


namespace App\Services;


use App\Models\Crew;
use App\Models\CrewResume;
use App\Models\CrewSocial;
use App\Models\User;
use App\Utils\StrUtils;
use Illuminate\Support\Facades\Storage;

class CrewsServices
{
    /**
     * Create crew and all its relations from the request data
     *
     * @param array $data
     * @param User  $user
     *
     * @return Crew
     */
    public function processCreate(array $data, User $user)
    {
        $crew = $this->create(
            array_merge(
                [
                    'user_id'   => $user->id,
                    'photo_dir' => $user->uuid,
                ],
                array_only($data, ['bio', 'photo'])
            ),
            $user
        );

        if (isset($data['resume'])) {
            $this->createGeneralResume([
                'crew_id'    => $crew->id,
                'resume'     => $data['resume'],
                'resume_dir' => $user->uuid,
            ]);
        }

        $this->createSocials($data['socials'], $crew);

        return $crew;
    }

    /**
     * Create crew
     *
     * @param array $data
     *
     * @return \App\Models\Crew
     */
    public function create(array $data)
    {
        $crew = Crew::create([
            'user_id' => $data['user_id'],
            'bio'     => $data['bio'],
            'photo'   => 'photos/'.$data['photo_dir'].'/'
                .$data['photo']->hashName(),
        ]);

        Storage::put($crew->photo, file_get_contents($data['photo']));

        return $crew;
    }

    /**
     * @param array $data
     *
     * @return \App\Models\CrewResume
     */
    public function createGeneralResume(array $data)
    {
        $resume = CrewResume::create([
            'crew_id' => $data['crew_id'],
            'url'     => 'resumes/'.$data['resume_dir'].'/'
                .$data['resume']->hashName(),
            'general' => 1,
        ]);

        Storage::put($resume->url, file_get_contents($data['resume']));

        return $resume;
    }

    /**
     * @param array $socialData
     * @param Crew  $crew
     */
    public function createSocials(array $socialData, Crew $crew)
    {
        $crewSocials = [];

        if (! empty($socialData['youtube']['url'])) {
            $socialData['youtube']['url'] = StrUtils::cleanYouTube($socialData['youtube']['url']);
        }

        foreach ($socialData as $data) {
            if ($data['url'] != '') {
                $crewSocials[] = new CrewSocial([
                    'social_link_type_id' => $data['id'],
                    'url'                 => $data['url'],
                ]);
            }
        }

        $crew->social()->saveMany($crewSocials);
    }
}