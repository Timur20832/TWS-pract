<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Orchid\Platform\Models\Role;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Создаём роль user для обычных пользователей, если её нет
        $userRole = Role::where('slug', 'user')->first();
        if (!$userRole) {
            $userRole = Role::create([
                'name' => 'User',
                'slug' => 'user',
                'permissions' => [
                    // Обычные пользователи не имеют доступа к админке
                    // Они могут только использовать API
                ],
            ]);
            $this->command->info('User role created successfully');
        } else {
            $this->command->info('User role already exists');
        }
    }
}
