<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadReadsTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->thread = factory(\App\Thread::class)->create();
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {

        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_single_thread(){

        $this->get($this->thread->path())
           ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_replies_with_a_thread(){

        $reply = factory(\App\Reply::class)->create(['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->title);
    }
}
