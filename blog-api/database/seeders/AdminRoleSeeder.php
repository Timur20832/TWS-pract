<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;

class AdminRoleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::find(10);

        if (!$user) {
            $this->command->error('User with ID 10 not found!');
            return;
        }

        // Права, которые хочешь выдать
        $permissions = [
            'platform.index' => true,
            'platform.systems.attachment' => true,
            'platform.systems.users' => true,
            'platform.posts.list' => true,
            'platform.systems.roles' => true,
            // добавь сюда ещё нужные права
        ];

        // Обновляем существующие права (если что-то уже есть)
        $currentPermissions = $user->permissions ?? [];
        $newPermissions = array_merge($currentPermissions, $permissions);

        $user->permissions = $newPermissions;
        $user->save();

        $this->command->info('Permissions updated for user ID 10');
    }
}
