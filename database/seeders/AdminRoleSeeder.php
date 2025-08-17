<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;

class AdminRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Создаём пользователя-админа, если его нет
        $user = User::where('email', 'admin@example.com')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin123'),
            ]);
            $this->command->info('Admin user created: admin@example.com / admin123');
        } else {
            $this->command->info('Admin user already exists: admin@example.com');
        }

        // Создаём роль admin, если её нет
        $role = Role::where('slug', 'admin')->first();
        if (!$role) {
            $role = Role::create([
                'name' => 'Administrator',
                'slug' => 'admin',
                'permissions' => [
                    'platform.index' => true,
                    'platform.systems.attachment' => true,
                    'platform.systems.users' => true,
                    'platform.posts.list' => true,
                ],
            ]);
            $this->command->info('Admin role created');
        } else {
            $this->command->info('Admin role already exists');
        }

        // Назначаем роль пользователю (если не назначена)
        if (method_exists($user, 'roles')) {
            if (!$user->roles()->where('slug', 'admin')->exists()) {
                $user->roles()->attach($role);
                $this->command->info('Admin role attached to user');
            }
        }

        // Выдаём все права напрямую пользователю
        $permissions = [
            'platform.index' => true,
            'platform.systems.attachment' => true,
            'platform.systems.users' => true,
            'platform.posts.list' => true,
        ];
        $user->permissions = $permissions;
        $user->save();
        $this->command->info('Permissions updated for admin user');
    }
}
