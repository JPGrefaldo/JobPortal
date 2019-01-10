<?php

namespace App\Services;

use App\Data\StoragePath;
use App\Models\Crew;
use App\Models\CrewReel;
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
     * @param \App\Models\User $user
     *
     * @return \App\Services\CrewsServices
     */
    public function processCreate(array $data, User $user)
    {
        if (isset($data['photo'])) {
            $crew = $this->create(
                array_only($data, ['bio']),
                $data['photo'],
                $user
            );
        } else {
            $crew = Crew::create([
                'user_id' => $user->id,
                'bio' => $data['bio'],
            ]);
        }

        if (isset($data['resume'])) {
            if ($data['resume'] instanceof UploadedFile) {
                $this->createGeneralResume($data['resume'], $crew);
            }
        }

        if (isset($data['reel'])) {
            $this->createGeneralReel(
                [
                    'url'     => $data['reel'],
                    'crew_id' => $crew->id,
                ],
                $crew
            );
        }

        if (isset($data['reel_file'])) {
            if ($data['reel_file'] instanceof UploadedFile) {
                $this->createGeneralReelFile($data['reel_file'], $crew);
            }
        }

        $this->createSocials($data['socials'], $crew);

        return $crew;
    }

    /**
     *
     * Create crew
     *
     * @param array $data
     * @param \Illuminate\Http\UploadedFile $photoFile
     * @param \App\Models\User $user
     *
     * @return \App\Models\Crew
     */
    public function create(array $data, UploadedFile $photoFile, User $user)
    {
        $data = array_merge(
            $this->prepareCrewData($data, [
                'file' => $photoFile,
                'dir'  => $user->hash_id,
            ]),
            ['user_id' => $user->id]
        );

        dump($data['photo']);
        Storage::disk('s3')->put($data['photo'], file_get_contents($photoFile));

        return Crew::create($data);
    }
    /**
     * @param \Illuminate\Http\UploadedFile $resumeFile
     * @param \App\Models\Crew $crew
     *
     * @return \App\Models\CrewResume
     */
    public function createGeneralResume(UploadedFile $resumeFile, Crew $crew)
    {
        $data = array_merge(
            $this->prepareGeneralFileData([
                'file' => $resumeFile,
                'dir'  => $crew->user->hash_id,
            ], 'resume'),
            ['general' => 1]
        );

        Storage::put($data['url'], file_get_contents($resumeFile));

        $resume = new CrewResume($data);

        $crew->resumes()->save($resume);

        return $resume;
    }

    /**
     * @param \Illuminate\Http\UploadedFile $reelFile
     * @param \App\Models\Crew $crew
     *
     * @return \App\Models\CrewResume
     */
    public function createGeneralReelFile(UploadedFile $reelFile, Crew $crew)
    {
        $data = array_merge(
            $this->prepareGeneralFileData([
                'file' => $reelFile,
                'dir'  => $crew->user->hash_id,
            ], 'reel'),
            ['general' => 1],
            ['type' => 'file']
        );


        Storage::put($data['url'], file_get_contents($reelFile));

        $reel = new CrewReel($data);

        $crew->reel()->save($reel);

        return $reel;
    }

    /**
     * @param array $socialData
     * @param \App\Models\Crew $crew
     */
    public function createSocials(array $data, Crew $crew)
    {
        foreach ($data as $key => $value) {
            if (! $value['url']) {
                continue;
            }

            if (str_contains($value['url'], ['youtube', 'youtu.be'])) {
                $value['url'] = $this->cleanReelUrl($value['url']);
            }

            CrewSocial::create([
                'crew_id' => $crew->id,
                'social_link_type_id' => $value['id'],
                'url' => $value['url'],
            ]);
        }
    }


    /**
     * @param array $data
     *
     * @return \App\Models\CrewReel
     */
    public function createGeneralReel(array $data, Crew $crew)
    {
        $data = array_merge(
            $this->prepareGeneralReelData($data),
            ['general' => 1],
            ['type' => 'link'],
            ['crew_id' => $crew->id]
        );

        $reel = CrewReel::create($data);

        return $reel;
    }

    /**
     * @param array $data
     *
     * @return array
     *
     */
    public function prepareGeneralReelData(array $data): array
    {
        $data['url'] = $this->cleanReelUrl($data['url']);

        return $data;
    }

    public function prepareGeneralResumeData(array $data): array
    {
        $url = 'resumes/' . $data['dir'] . '/' . $data['file']->hashName();

        return compact('url');
    }

    /**
     * Clean youtube or vimeo URL
     *
     * @param string $url
     *
     * @return string
     */
    public function cleanReelUrl(string $url)
    {
        $youtubeUrl = StrUtils::cleanYouTube($url);

        if (parse_url($youtubeUrl, PHP_URL_HOST) === 'www.youtube.com') {
            return $youtubeUrl;
        }

        return SocialLinksServices::cleanVimeo($url);
    }

    /**
     * Update crew and all its relations from the request data
     *
     * @param array $data
     * @param \App\Models\Crew $crew
     *
     * @return \App\Models\Crew
     * @throws \Exception
     */
    public function processUpdate(array $data, Crew $crew)
    {
        if (isset($data['photo'])) {
            $crew = $this->update(
                array_only($data, ['bio']),
                $data['photo'],
                $crew
            );
        } else {
            $crew->update([
                'bio' => $data['bio'],
            ]);
        }

        if (isset($data['resume'])) {
            if ($data['resume'] instanceof UploadedFile) {
                $this->updateGeneralResume($data['resume'], $crew);
            }
        }

        if (isset($data['reel'])) {
            if ($data['reel'] instanceof UploadedFile) {
                $this->updateGeneralReelFile($data['reel'], $crew);
            } else {
                $this->updateGeneralReel(
                    ['url' => $data['reel'],
                        'type' => 'link'],
                    $crew
                );
            }
        }

        if (isset($data['socials'])) {
            $this->updateSocials($data['socials'], $crew);
        }

        return $crew;
    }

    /**
     * @param array $data
     * @param null|\Illuminate\Http\UploadedFile $photoFile
     * @param \App\Models\Crew $crew
     *
     * @return \App\Models\Crew
     */
    public function update(array $data, $photoFile, Crew $crew)
    {
        $hasPhoto = ($photoFile instanceof UploadedFile);
        $photoData = [
            'file' => $photoFile,
            'dir'  => ($hasPhoto) ? $crew->user->hash_id : '',
        ];
        $data = $this->prepareCrewData($data, $photoData);

        if ($hasPhoto) {
            Storage::delete($crew->photo); // delete old photo
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
                . 'photo'
                . '/'
                . $photoData['file']->hashName();
        }

        return $data;
    }

    /**
     * @param \Illuminate\Http\UploadedFile $resumeFile
     * @param \App\Models\Crew $crew
     *
     * @return \App\Models\CrewResume
     */
    public function updateGeneralResume(UploadedFile $resumeFile, Crew $crew)
    {
        $resume = CrewResume::where('crew_id', $crew->id)
            ->where('general', 1)
            ->first();

        if (! $resume) {
            $resume = $this->createGeneralResume($resumeFile, $crew);

            return $resume;
        }

        $data = $this->prepareGeneralFileData([
            'file' => $resumeFile,
            'dir'  => $crew->user->hash_id,
        ], 'resume');

        // delete the old resume and store the new one
        Storage::delete($resume->url);
        Storage::put($data['url'], file_get_contents($resumeFile));

        $resume->update($data);

        return $resume;
    }

    /**
     * @param \Illuminate\Http\UploadedFile $reelFile
     * @param \App\Models\Crew $crew
     *
     * @return \App\Models\CrewReel
     */
    public function updateGeneralReelFile(UploadedFile $reelFile, Crew $crew)
    {
        $reel = CrewReel::where('crew_id', $crew->id)
            ->where('general', 1)
            ->first();

        if (! $reel) {
            $reel = $this->createGeneralReelFile($reelFile, $crew);

            return $reel;
        }

        $data = $this->prepareGeneralFileData([
            'file' => $reelFile,
            'dir'  => $crew->user->hash_id,
        ], 'reel');

        // delete the old resume and store the new one
        Storage::delete($reel->url);
        Storage::put($data['url'], file_get_contents($reelFile));

        $reel->update($data);

        return $reel;
    }

    /**
     * @param array $resumeData
     * @param string $type
     *
     * @return array
     */
    public function prepareGeneralFileData(array $fileData, string $type)
    {
        if ($type === 'reel') {
            return [
                'url' => StoragePath::BASE_REEL
                    . '/' . $fileData['dir']
                    . '/' . $fileData['file']->hashName(),
            ];
        } elseif ($type === 'resume') {
            return [
                'url' => StoragePath::BASE_RESUME
                    . '/' . $fileData['dir']
                    . '/' . $fileData['file']->hashName(),
            ];
        }
    }


    /**
     * @param array $socialData
     * @param \App\Models\Crew $crew
     *
     * @throws \Exception
     */
    public function updateSocials(array $socialData, Crew $crew)
    {
        CrewSocial::where('crew_id', $crew->id)->delete();

        $this->createSocials($socialData, $crew);
    }

    /**
     * @param array $data
     * @param \App\Models\Crew $crew
     *
     * @return \App\Models\CrewReel
     */
    public function updateGeneralReel(array $data, Crew $crew)
    {
        $reel = CrewReel::whereCrewId($crew->id)->whereGeneral(1)->first();

        if (! $reel) {
            return $this->createGeneralReel(array_merge(
                $data,
                ['crew_id' => $crew->id]
            ), $crew);
        }

        $reel->update($this->prepareGeneralReelData($data));

        return $reel;
    }
}
