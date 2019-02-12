<?php

namespace Tests\Unit\Actions\Endorsement;

use App\Actions\Endorsement\CreateOrGetEndorserByEmail;
use App\Models\EndorsementEndorser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CreateOrGetEndorserByEmailTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var CreateOrGetEndorserByEmail
     */
    public $service;
    /**
     * @var string
     */
    public $email;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(CreateOrGetEndorserByEmail::class);
        $this->email = 'test@test.com';
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\CreateOrGetEndorserByEmail::execute
     */
    public function execute_is_not_a_user()
    {
        $this->service->execute($this->email);

        $this->assertDatabaseHas('endorsement_endorsers', [
            'email' => $this->email,
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => $this->email,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\CreateOrGetEndorserByEmail::execute
     */
    public function execute_is_not_a_user_but_is_an_endorser()
    {
        $endorser = factory(EndorsementEndorser::class)->state('notUser')->create([
            'email' => $this->email,
        ]);

        $returned = $this->service->execute($this->email);

        $this->assertEquals(1, EndorsementEndorser::count());
        $this->assertEquals($endorser->id, $returned->id);
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\CreateOrGetEndorserByEmail::execute
     */
    public function execute_already_a_user()
    {
        $user = $this->createUser([
            'email' => $this->email,
        ]);
        $this->service->execute($this->email);

        $this->assertDatabaseMissing('endorsement_endorsers', [
            'email' => $this->email,
        ]);

        $this->assertDatabaseHas('endorsement_endorsers', [
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $this->email,
        ]);
    }

    /**
     * @test
     * @covers \App\Actions\Endorsement\CreateOrGetEndorserByEmail::execute
     */
    public function execute_already_a_user_and_endorser()
    {
        $user = $this->createUser([
            'email' => $this->email,
        ]);

        $endorser = factory(EndorsementEndorser::class)->state('isUser')->create([
            'user_id' => $user->id,
        ]);

        $returned = $this->service->execute($this->email);

        $this->assertEquals(1, EndorsementEndorser::count());
        $this->assertEquals($endorser->id, $returned->id);
    }
}
