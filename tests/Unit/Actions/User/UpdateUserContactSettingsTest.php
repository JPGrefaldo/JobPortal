<?php

namespace Tests\Actions\User;

use App\Actions\User\UpdateUserContactSettings;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class UpdateUserContactSettingsTest extends TestCase
{
    use DatabaseMigrations, SeedDatabaseAfterRefresh;

    /**
     * @var UpdateUserContactSettings
     */
    public $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(UpdateUserContactSettings::class);
    }

    /**
     * @test
     * @covers \App\Actions\User\UpdateUserContactSettings::execute
     */
    public function valid_data()
    {
        $user = factory(User::class)->create();
        $data = [
            'email' => 'test@test.com',
            'phone' => '5555555555',
        ];

        $this->service->execute($user, $data);
        $user->refresh();

        $this->assertEquals($data, [
            'email' => $user->email,
            'phone' => $user->phone,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\User\UpdateUserContactSettings::cleanData
     */
    public function clean_data()
    {
        $data = [
            'email' => 'test@test.com',
            'phone' => '5555555555',
        ];

        $this->assertEquals($data, $this->service->cleanData($data));
    }

    /**
     * @test
     * @covers \App\Actions\User\UpdateUserContactSettings::cleanData
     */
    public function clean_data_with_formatted_phone()
    {
        $data = [
            'email' => 'test@test.com',
            'phone' => '(555) 555-5555',
        ];

        $this->assertEquals([
            'email' => 'test@test.com',
            'phone' => '5555555555',
        ], $this->service->cleanData($data));
    }
}
