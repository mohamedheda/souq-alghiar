<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'User',
            'email' => 'user@souq-alghiar.com',
            'phone' => '010123456',
            'user_name' => 'username',
            'password' => 'souq-alghiar1256!#',
            'city_id' => City::first()->id ,
        ]);
    }
}
