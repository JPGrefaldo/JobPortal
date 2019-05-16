<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ThreadFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
    * @test
    * @covers App\Http\Controllers\API\ParticipantController::search
    */
    public function search_participating_user_in_current_thread()
    {
        $response = $this->search('J');

        $response->assertJsonFragment([
            'name' => 'John Doe',
        ]);

        $response->assertJsonFragment([
            'name' => 'Jean Grey',
        ]);
    }

    /**
     * @test
     * @covers App\Http\Controllers\API\ParticipantController::search
     */
    public function current_user_should_not_be_included_in_search_result()
    {
        $currentUser = $this->createProducer();

        $response = $this->search('J', $currentUser);

        $response->assertJsonMissing([
            'name' => $currentUser->first_name,
        ]);
    }

    /**
     * @test
     * @covers App\Http\Controllers\API\ParticipantController::search
     */
    public function search_will_accept_any_input_format()
    {
        $response = $this->search('JOHN');
        $response->assertJsonFragment([
            'name' => 'John Doe',
        ]);

        $response = $this->search('JeAn');
        $response->assertJsonFragment([
            'name' => 'Jean Grey',
        ]);
    }

    /**
     * @test
     * @covers App\Http\Controllers\API\ParticipantController::search
     */
    public function search_keyword_should_not_be_empty()
    {
        $response = $this->search('');

        $response->assertJson([
            'message' => 'Keyword should not be empty',
        ]);
    }

    /**
     * @test
     * @covers App\Http\Controllers\API\ParticipantController::search
     */
    public function search_keywords_should_not_contain_numbers()
    {
        $response = $this->search('J0hn');

        $response->assertJson([
            'message' => 'Keyword should only be a string',
        ]);
    }

    /**
     * @test
     * @covers App\Http\Controllers\API\ParticipantController::search
     */
    public function show_search_info_when_no_results_found()
    {
        $response = $this->search('Superman');

        $response->assertJson([
            'message' => 'No results can be found',
        ]);
    }


    private function search($keyword, $currentUser = null)
    {
        // So that this will work test_current_user_should_not_be_included_in_search_result()
        if ($currentUser == null) {
            $currentUser = $this->createProducer();
        }

        $thread = $this->threadParticipants($currentUser);

        $this->actingAs($currentUser, 'api')
            ->get(route(
                'messages.index',
                [
                    'thread' => $thread->id,
                ]
            ));

        return $this->actingAs($currentUser)
            ->postJson(route('threads.search.participants', [
                'thread'  => $thread->id,
                'keyword' => $keyword,
            ]));
    }

    private function threadParticipants($currentUser)
    {
        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject',
        ]);

        $participant1 = factory(User::class)->create([
            'nickname' => 'John Doe',
        ]);

        $participant2 = factory(User::class)->create([
            'nickname' => 'Jean Grey',
        ]);

        $thread->addParticipant([
            $currentUser->id,
            $participant1->id,
            $participant2->id,
        ]);

        $this->assertCount(
            3,
            $thread->participants()
                ->get()
                ->toArray()
        );

        return $thread;
    }
}
