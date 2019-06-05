<?php

namespace Tests\Unit\Rules;

use App\Models\EndorsementEndorser;
use App\Rules\CreateCrewEndorsement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CreateCrewEndorsementTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp(): void
    {
        parent::setUp();

        $this->user1 = $this->createCrew();
        $this->user2 = $this->createCrew();
    }

    /**
     * @test
     * @covers \App\Rules\CreateCrewEndorsement::passes
     */
    public function valid()
    {
        $result = $this->validate($this->user2->email);

        $this->assertTrue($result->passes());
    }

    /**
     * @test
     * @covers \App\Rules\CreateCrewEndorsement::passes
     */
    public function invalid_own_email()
    {
        factory(EndorsementEndorser::class)->create([
            'email' => $this->user1->email,
        ]);

        $result = $this->validate($this->user1->email);
        $this->assertFalse($result->passes());
    }

    public function validate($email)
    {
        $this->actingAs($this->user1);

        return $this->app['validator']->make(
            [
                'email'   => $email,
                'message' => 'Some test message',
            ],
            [
                'email'   => [
                    'required',
                    'email',
                    new CreateCrewEndorsement,
                ],
                'message' => 'required',
            ]
        );
    }
}
