<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ThreadsCreateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_cannot_create_forum_thread(){
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('login');
        $this->post('/threads', [])
            ->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_can_create_a_forum_thread()
    {
        $this->signIn();

        $thread = make(Thread::class);

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_required_title()
    {
        $this->publishThread(['title' => null])->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_required_body()
    {
        $this->publishThread(['body' => null])->assertSessionHasErrors('body');
    }


    /** @test */
    public function a_thread_required_channel_id()
    {
        $this->publishThread(['channel_id' => null])->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id' => 999])->assertSessionHasErrors('channel_id');
    }

    protected function publishThread($override = []){

        $this->withExceptionHandling()->signIn();

        $thread = make(Thread::class, $override);

        return $this->post('/threads', $thread->toArray());
    }
}
