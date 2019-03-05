<?php

namespace Tests\Feature;

use App\Models\Role;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use App\Models\User;

class ThreadFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

     /**
     * @test
     * @covers App\Http\Controllers\API\ParticipantsController::search
     */
    public function search_user_that_participating_in_the_current_thread()
    {
        $response = $this->search('J');
        
        $response->assertJsonFragment([
            'first_name' => 'John'
        ]);
     
        $response->assertJsonFragment([
            'first_name' => 'Jean'
        ]);
    }

    public function test_current_user_should_not_be_included_in_search_result()
    {
        $currentUser = $this->createProducer();

        $response = $this->search('J', $currentUser);

        $response->assertJsonMissing([
            'first_name' => $currentUser->first_name
        ]);
    }

    public function test_search_will_accept_any_input_format()
    {
        $response = $this->search('JOHN');
        $response->assertJsonFragment([
            'first_name' => 'John'
        ]);
     
        $response = $this->search('JeAn');
        $response->assertJsonFragment([
            'first_name' => 'Jean'
        ]);
    }

    public function test_search_keyword_should_not_be_empty()
    {
        $response = $this->search('');

        $response->assertJson([
            'invalid' => 'Keyword should not be empty'
        ]);
    }

    public function test_search_keywords_should_not_contain_numbers()
    {
        $response = $this->search('J0hn');

        $response->assertJson([
            'invalid' => 'Keyword should only be a string'
        ]);
    }
    

    private function search($keyword, $currentUser=null)
    {
        // So that this will work test_current_user_should_not_be_included_in_search_result()
        if($currentUser == null){
            $currentUser = $this->createProducer();
        }

        $thread = $this->threadParticipants($currentUser);

        $this->actingAs($currentUser, 'api')
             ->get(route('messages.index', [
                    'thread' => $thread->id
                ]
             ));

        return $this->actingAs($currentUser)
                    ->postJson(route('threads.search.participants', [
                        'thread' => $thread->id,
                        'keyword' => $keyword
                    ]));
    }

    private function threadParticipants($currentUser)
    {
        $thread = factory(Thread::class)->create([
            'subject' => 'Thread Test Subject'
        ]);

        $participant1 = factory(User::class)->create([
            'first_name' => 'John',
            'last_name' => 'Doe'
        ]); 

        $participant2 = factory(User::class)->create([
            'first_name' => 'Jean',
            'last_name' => 'Grey'
        ]); 

        $participants = collect([
            $currentUser->id, 
            $participant1->id, 
            $participant2->id
        ]);
        
        $participants->each(function($participant) use($thread){
            $thread->addParticipant($participant);
        });

        $this->assertCount(3, 
            $thread->participants()
                   ->get()
                   ->toArray()
        );

        return $thread;
    }
}
