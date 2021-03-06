<?php

namespace Tests\Unit\Actions\Endorsement;

use App\Actions\Endorsement\GetEndorserUserID;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class GetEndorserUserIDTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var GetEndorserUserID
     */
    public $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(GetEndorserUserID::class);
    }

    /**
     * @test
     * @covers GetEndorserUserID::execute
     */
    public function execute()
    {
        $user = $this->createUser([
            'email' => 'test@test.com',
        ]);

        $endorser = $this->service->execute('test@test.com');

        $this->assertEquals($user->last_name, $endorser->last_name);
    }

    /**
     * @test
     * @covers GetEndorserUserID::execute
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function no_a_user_yet()
    {
        $this->service->execute('test@test.com');
    }
}
