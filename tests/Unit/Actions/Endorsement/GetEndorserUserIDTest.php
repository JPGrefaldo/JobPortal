<?php

namespace Tests\Unit\Actions\Endorsement;

use App\Actions\Endorsement\GetEndorserUserID;
use App\Models\User;
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

    public function setUp()
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
        $user = factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $endorser = $this->service->execute('test@test.com');

        $this->assertEquals($user->last_name, $endorser->last_name);
    }

    /**
     * @test
     * @covers GetEndorserUserID::execute
     */
    public function no_a_user_yet()
    {
        $this->assertNull($this->service->execute('test@test.com'));
    }
}
