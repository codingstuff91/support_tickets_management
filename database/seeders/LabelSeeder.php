<?php

namespace Database\Seeders;

use App\Models\Label;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Label::create(['name' => 'Bug']);
        Label::create(['name' => 'Improvement']);
        Label::create(['name' => 'Question']);
    }
}
