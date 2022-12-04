<?php

namespace Tests\Feature\Comment;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp() :void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        
        $this->ticket = Ticket::factory()->create();        
    }

    public function test_the_tickets_comments_can_be_displayed()
    {
        $comment = Comment::factory()->create();

        $response = $this->get('/tickets/' . $this->ticket->id);
        $response->assertOk();
        $response->assertSee($comment->body);
        $response->assertSee($comment->user->name);
    }

    public function test_the_create_comment_form_should_be_rendered()
    {
        $response = $this->get('/tickets/' . $this->ticket->id);

        $response->assertOk();
        $response->assertSee('Comments');
        $response->assertSee('Add a new comment');
    }
}