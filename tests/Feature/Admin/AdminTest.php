<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        Parent::setUp();

        Role::factory()->create();

        Role::factory([
            'name' => 'Admin',
        ])->create();

        $this->admin = User::factory()->create([
            'role_id' => Role::whereName('Admin')->get()->first()->id
        ]);

        $this->user = User::factory()->create([
            'role_id' => Role::first()->id,
        ]);

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
}
