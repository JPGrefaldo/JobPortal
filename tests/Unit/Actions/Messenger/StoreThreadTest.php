<?php

namespace Tests\Unit\Actions\Messenger;

use App\Actions\Messenger\StoreThread;
use App\Models\Thread;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class StoreThreadTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
    * @test
    * @covers App\Actions\Messenger\StoreThread::execute
    */
    public function can_store_a_thread()
    {
        $subject  = 'Some test subject';
        $project  = factory(Project::class)->create();
        
        app(StoreThread::class)->execute($project, $subject);

        $this->assertCount(1, Thread::all());
    }
}
