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
        $postsRemoveAbility = Ability::create([
            'name' => 'Удаление чужих постов',
            'tag' => 'posts:remove',
        ]);
        $usersRemoveAbility = Ability::create([
            'name' => 'Удаление чужих аккаунтов',
            'tag' => 'users:remove',
        ]);
        $adminRole->abilities()->attach($adminViewAbility->id);
        $adminRole->abilities()->attach($postsRemoveAbility->id);
        $adminRole->abilities()->attach($usersRemoveAbility->id);
    }
}
