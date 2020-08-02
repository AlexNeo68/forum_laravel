<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateToForumTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->thread = create(Thread::class);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_reply(){
        $this->withExceptionHandling()
            ->post($this->thread->path().'/replies', [])
            ->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_can_participate_to_the_forum()
    {
        $this->signIn();

        $reply = make(Reply::class);

        $this->post($this->thread->path().'/replies', $reply->toArray());

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_body_required()
    {
        $this->withExceptionHandling()->signIn();

        $reply = make(Reply::class, ['body' => null]);

        $this->post($this->thread->path().'/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
