<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categroy::create(['name' => 'Technical']);
        Categroy::create(['name' => 'Payment']);
        Categroy::create(['name' => 'Invoice/billing']);
    }
}
