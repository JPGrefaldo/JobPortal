<?php

namespace Tests\Unit;

use Illuminate\Support\Arr;
use App\Models\Crew;
use Illuminate\Foundation\Testing\DatabaseMigrations  ;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class GetCrewPhotoUrlTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;
    /**
     * @test
     * @covers  \App\Models\Crew::getPhotoUrlAttribute
     */
    public function get_photo_url_attribute()
    {
        $crew = factory(Crew::class)->create();
        $data = $this->getUploadData();

        $crew->photo =
            config('filesystems.disks.s3.url') . '/' .
            config('filesystems.disks.s3.bucket') .
            $crew->hash_id . '/' .
            'photo' . '/' .
            $data['photo']->hashName();

        $this->assertEquals(
            config('filesystems.disks.s3.url') . '/' .
            config('filesystems.disks.s3.bucket') .
            $crew->hash_id . '/' .
            'photo' . '/' .
            $data['photo']->hashName(),
            $crew->photo_url
        );
    }

    public function getUploadData($customData = [])
    {
        $data = [
            'photo' => UploadedFile::fake()
                ->image('photo.png'),
        ];

        return $this->customizeData($data, $customData);
    }

    /**
     * @param $data
     * @param $customData
     *
     * @return mixed
     */
    protected function customizeData($data, $customData)
    {
        foreach ($customData as $key => $value) {
            Arr::set($data, $key, $value);
        }

        return $data;
    }
}
