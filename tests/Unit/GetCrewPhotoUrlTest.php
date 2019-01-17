<?php

namespace Tests\Unit;

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
        $user = $this->createCrew();
        $data = $this->getUploadData();

        $this->assertEquals(
            config('disks.s3.url') . '/' .
            config('disks.s3.bucket') .
            $user->hash_id . '/' .
            'photo' . '/' .
            $data['photo']->hashName(),
            $user->photo_url
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
            array_set($data, $key, $value);
        }

        return $data;
    }
}
