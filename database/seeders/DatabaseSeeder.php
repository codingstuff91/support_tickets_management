<?php

namespace Database\Seeders;

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
            UserSeeder::class,
        ]);

        // Create a ticket with one label and one category
        $ticket = Ticket::factory()->create();
        $label = Label::first();
        $category = Category::first();

        $ticket->labels()->attach($label);
        $ticket->categories()->attach($category);
    }
}
