<?php

namespace Tests\Unit\Actions\Endorsement;

use App\Actions\Endorsement\ConvertEndorserFromEmailToUser;
use App\Models\EndorsementEndorser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ConvertEndorserFromEmailToUserIDTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var ConvertEndorserFromEmailToUser
     */
    public $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(ConvertEndorserFromEmailToUser::class);
    }

    /**
     * @test
     * @covers ConvertEndorserFromEmailToUser::execute
     */
    public function execute()
    {
        $endorser = EndorsementEndorser::create([
            'email' => 'test@test.com',
        ]);

        $user = $this->createUser([
            'email' => 'test@test.com',
        ]);

        $this->assertNull($endorser->user_id);

        $this->service->execute($user);
        $endorser->refresh();

        $this->assertEquals($user->id, $endorser->user_id);
    }

    /**
     * @test
     * @covers ConvertEndorserFromEmailToUser::execute
     */
    public function not_an_endorser_yet()
    {
        $user = $this->createUser([
            'email' => 'test@test.com',
        ]);

        $this->service->execute($user);

        $this->assertEquals(0, EndorsementEndorser::count());
    }
}
