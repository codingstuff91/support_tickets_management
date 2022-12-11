<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        Parent::setUp();

        Role::factory(['name' => 'User'])->create();
        Role::factory(['name' => 'Admin'])->create();
        Role::factory(['name' => 'Agent'])->create();

        $this->admin = User::factory()->create([
            'role_id' => Role::whereName('Admin')->get()->first()->id
        ]);

        $this->agent = User::factory()->create([
            'role_id' => Role::whereName('Agent')->get()->first()->id
        ]);

        $this->user = User::factory()->create([
            'role_id' => Role::whereName('User')->get()->first()->id,
        ]);

        $this->unassignedTicket = Ticket::factory()->create();
    }

    public function test_a_non_admin_user_could_not_access_to_admin_page()
    {
        $this->actingAs($this->user);

        $response = $this->get('admin');

        $response->assertStatus(403);    
    }

    public function test_a_admin_can_access_to_admin_page()
    {
        $this->actingAs($this->admin);

        $response = $this->get('admin');

        $response->assertOk();  
    }

    public function test_the_assign_ticket_page_can_be_rendered_with_list_of_every_agents()
    {
        $this->actingAs($this->admin);

        $response = $this->get('admin/tickets/' .$this->unassignedTicket->id . '/assign');

        $response->assertOk();
        $response->assertSee('Assign ticket to an agent');
        $response->assertSee($this->agent->name);
    }

    public function test_a_ticket_can_be_assigned_to_an_agent()
    {
        $this->actingAs($this->admin);

        $response = $this->put('admin/tickets/' .$this->unassignedTicket->id . '/assign', [
            'agent_id' => $this->agent->id
        ]);

        $this->assertEquals($this->agent->id, (int)Ticket::first()->agent_id);
        $response->assertRedirect('/admin');
    }
}
