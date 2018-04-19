<?php


namespace App\Services;


use App\Data\StoragePath;
use App\Models\Crew;
use App\Models\CrewResume;
use App\Models\CrewSocial;
use App\Models\User;
use App\Utils\StrUtils;
use Illuminate\Http\UploadedFile;
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

        if (!empty($data['resume'])) {
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
        $data['bio'] = $data['bio'] ?: '';

        $crew = Crew::create([
            'user_id' => $data['user_id'],
            'bio'     => $data['bio'],
            'photo'   => 'photos/' . $data['photo_dir'] . '/' . $data['photo']->hashName(),
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
            'url'     => 'resumes/' . $data['resume_dir'] . '/' . $data['resume']->hashName(),
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

        if (!empty($socialData['youtube']['url'])) {
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

    /**
     * @param array $data
     * @param Crew  $crew
     *
     * @return Crew
     */
    public function processUpdate(array $data, Crew $crew)
    {
        $crew = $this->update(
            array_only($data, ['bio']),
            $data['photo'],
            $crew
        );

        return $crew;
    }

    /**
     * @param array $data
     * @param null|\Illuminate\Http\UploadedFile $photoFile
     * @param \App\Models\Crew  $crew
     *
     * @return \App\Models\Crew
     */
    public function update(array $data, $photoFile, Crew $crew)
    {
        $hasPhoto  = ($photoFile instanceof UploadedFile);
        $photoData = [
            'file' => $photoFile,
            'dir'  => ($hasPhoto) ? $crew->user->uuid : '',
        ];
        $data      = $this->prepareCrewData($data, $photoData);

        if ($hasPhoto) {
            // delete old photo
            Storage::delete($crew->photo);
            Storage::put($data['photo'], file_get_contents($photoFile));
        }

        $crew->update($data);

        return $crew;
    }

    /**
     * @param array $data
     * @param array $photoData
     *
     * @return array
     */
    public function prepareCrewData(array $data, array $photoData)
    {
        $data['bio'] = $data['bio'] ?: '';

        if ($photoData['file'] instanceof UploadedFile) {
            $data['photo'] = StoragePath::BASE_PHOTO
                . '/'
                . $photoData['dir']
                . '/'
                . $photoData['file']->hashName();
        }

        return $data;
    }
}