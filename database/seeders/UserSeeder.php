<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'receiver8@yandex.ru',
            'password' => Hash::make('123abc'),
        ]);

        $user = User::factory()->create([
            'email' => 'admin@yandex.ru',
            'password' => Hash::make('123abc'),
            'role_id' => 2,
        ]);
    }
}
