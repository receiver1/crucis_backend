<?php

namespace Database\Seeders;

use App\Models\Ability;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRole = Role::factory()->create([
            'id' => 1,
            'name' => 'Пользователь',
        ]);

        $adminRole = Role::factory()->create([
            'id' => 2,
            'name' => 'Администратор',
        ]);

        $adminViewAbility = Ability::create([
            'name' => 'Просмотр админ-панели',
            'tag' => 'admin:view',
        ]);
        $adminRole->abilities()->attach($adminViewAbility->id);
    }
}
