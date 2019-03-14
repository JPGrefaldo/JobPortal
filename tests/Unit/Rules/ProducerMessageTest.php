<?php

namespace Tests\Unit\Rules;

use App\Models\Crew;
use App\Models\Project;
use App\Rules\ProducerMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProducerMessageTest extends TestCase
{
    use RefreshDatabase;

    protected $recipients;

    public function setUp()
    {
        parent::setup();

        $crews = factory(Crew::class, 3)->create();
        $project = factory(Project::class)->create();
        $this->project = $project;
        $project->contributors()->attach($crews);
        $recipients = $crews->map(function ($crew) {
            return $crew->user->hash_id;
        });
        $this->recipients = $recipients->toArray();
    }
    /**
     * @test
     * @covers \App\Rules\Facebook::passes
     */
    public function valid()
    {
        $result = $this->app['validator']->make(
            [
                'recipients' => $this->recipients,
            ],
            [
                'recipients' => [
                    'required',
                    'array',
                    'distinct',
                    'exists:users,hash_id',
                    new ProducerMessage($this->project),
                ],
            ]
        );

        $this->assertTrue($result->passes());
    }

    /**
     * @test
     * @covers \App\Rules\Facebook::passes
     */
    public function invalid()
    {
        $project = factory(Project::class)->create();

        $result = $this->app['validator']->make(
            [
                'recipients' => $this->recipients,
            ],
            [
                'recipients' => [
                    'required',
                    'array',
                    'distinct',
                    'exists:users,hash_id',
                    new ProducerMessage($project),
                ],
            ]
        );

        $this->assertFalse($result->passes());
        $this->assertEquals(
            'The selected recipients is invalid.',
            $result->errors()->first()
        );
    }
}
