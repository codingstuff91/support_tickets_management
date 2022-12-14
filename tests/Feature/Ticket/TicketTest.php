<?php

namespace Tests\Feature\Ticket;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Notifications\NewTicketCreatedNotification;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        // Create an admin role
        $this->adminRole = Role::factory([
            'name' => 'Admin',
        ])->create();
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

    public function test_a_notification_is_sent_to_admins_after_ticket_creation()
    {
        Notification::fake();

        $admin = User::factory()->create([
            'role_id' => Role::whereName('Admin')->get()->first()->id,    
        ]);

        $response = $this->post('/tickets', $this->validFields([]));

        Notification::assertSentTo($admin, NewTicketCreatedNotification::class);
    }

    public function test_the_tickets_index_list_is_rendered_correctly()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->get('tickets');

        $response->assertOk();
        $response->assertSee($ticket->title);
        $response->assertSee($ticket->priority);
        $response->assertSee($ticket->status);
        $response->assertSee(substr($ticket->description,0,60));
    }

    public function test_the_ticket_details_page_should_display_ticket_informations()
    {
        $ticket = Ticket::factory()->create();
        $category = Category::factory()->create();
        $ticket->categories()->attach($category);
        $label = Label::factory()->create();
        $ticket->labels()->attach($label);  

        $response = $this->get('tickets/' . $ticket->id);

        $response->assertOk();
        $response->assertSee($ticket->title);
        $response->assertSee($ticket->description);
        $response->assertSee($ticket->priority);
        $response->assertSee($ticket->status);

        // We should see the labels and the categories
        $response->assertSee($ticket->categories->first()->name);
        $response->assertSee($ticket->labels->first()->name);
    }

    public function test_the_update_button_should_not_be_visible_by_a_different_user()
    {
        $ticket = Ticket::factory()->create();
        $anotherUser = User::factory()->create();
        $this->actingAs($anotherUser);

        $response = $this->get('/tickets/' . $ticket->id);
        $response->assertOk();
        $response->assertDontSee('Edit Ticket', false);
    }

    public function test_the_edit_page_can_be_rendered_with_ticket_informations()
    {
        $ticket = Ticket::factory()->create();

        $category = Category::factory()->create();
        $label = Label::factory()->create();
        $ticket->categories()->attach($category);
        $ticket->labels()->attach($label);

        $response = $this->get('/tickets/' . $ticket->id . '/edit');
        $response->assertOk();
        $response->assertSee($ticket->title);
        $response->assertSee($ticket->description);
        $response->assertSee($ticket->priority);

        // test if the good category and label are checked
        $response->assertSee("value=\"" . $category->id . "\" checked", false);
        $response->assertSee("value=\"" . $label->id . "\" checked", false);
    }

    public function test_a_ticket_can_be_updated()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->put('tickets/' . $ticket->id, [
            "title" => "title modification",
            "description" => "description modification",
            "priority" => "priority modification",
            "labels" => ["1", "3"],
            "categories" => ["1", "2"]
        ]);

        $this->assertEquals('title modification', Ticket::first()->title);
    }
}
