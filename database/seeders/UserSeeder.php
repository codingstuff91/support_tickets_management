<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Matthieu',
            'email' => 'mattou2812@gmail.com',
            'password' => bcrypt('secret'),
            'role_id' => Role::first()->id,
            'remember_token' => Str::random(30)
        ]);
    }
}
