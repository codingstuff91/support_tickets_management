<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
            LabelSeeder::class,
        ]);

        // Create 1 admin user
        User::factory()->create([
            'email' => 'mattou2812@gmail.com',
            'role_id' => Role::whereName('admin')->get()->first()->id
        ]);

        // Create 1 agent user
        User::factory()->create([
            'email' => 'jamesbond@gmail.com',
            'role_id' => Role::whereName('agent')->get()->first()->id
        ]);
        
        // Create 5 regular users
        User::factory(5)->create();

        // Create a ticket with one label and one category
        $ticket = Ticket::factory()->create();
        $label = Label::first();
        $category = Category::first();

        $ticket->labels()->attach($label);
        $ticket->categories()->attach($category);
    }
}
