<?php

namespace Tests\Feature\Ticket;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_the_ticket_create_page_can_be_rendered()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $response = $this->get('/tickets/create');

        $response->assertOk();
        $response->assertSee('New ticket creation');
    }

    protected function validFields($attributes)
    {
        return array_merge([
            'title' => 'example',
            'description' => 'example description',
            'priority' => 'low',
            'labels' => ["1"],
            'categories' => ["1"]
        ], $attributes);
    }

    public function test_a_ticket_needs_a_title()
    {
        $response = $this->post('/tickets', $this->validFields(['title' => '']));
        
        $response->assertSessionHasErrors(['title']);
    }

    public function test_a_ticket_needs_a_description()
    {
        $response = $this->post('/tickets', $this->validFields(['description' => '']));
        
        $response->assertSessionHasErrors(['description']);
    }

    public function test_a_ticket_needs_a_priority()
    {
        $response = $this->post('/tickets', $this->validFields(['priority' => '']));
        
        $response->assertSessionHasErrors(['priority']);
    }

    public function test_a_ticket_needs_at_least_one_label()
    {
        $response = $this->post('/tickets', $this->validFields(['labels' => '']));
        
        $response->assertSessionHasErrors(['labels']);
    }

    public function test_a_ticket_needs_at_least_one_category()
    {
        $response = $this->post('/tickets', $this->validFields(['categories' => '']));
        
        $response->assertSessionHasErrors(['categories']);
    }

    public function test_a_ticket_is_created_successfully()
    { 
        $response = $this->post('/tickets', $this->validFields([]));

        $response->assertOk();
        $this->assertDatabaseCount('tickets', 1);
    }

    public function test_the_tickets_index_list_is_rendered_correctly()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->get('tickets');

        $response->assertOk();
        $response->assertSeeInOrder([
            'Tickets list', 
            $ticket->title,
            $ticket->status, 
            $ticket->description,
        ]);
    }
}
