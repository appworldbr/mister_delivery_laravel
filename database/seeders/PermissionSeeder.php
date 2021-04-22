<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->clearRoles();

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $this->createAdminUser($adminRole);
        $this->createPermissions('user', $adminRole);
        $this->createPermissions('workSchedule', $adminRole);
        $this->createPermissions('settings', $adminRole, ['update']);
        $this->createPermissions('deliveryArea', $adminRole);
        $this->createPermissions('foodCategory', $adminRole);
        $this->createPermissions('food', $adminRole);
        $this->createPermissions('foodExtra', $adminRole);

        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $this->createManagerUser($managerRole);
        $this->createPermissions('user', $managerRole, ['read']);
        $this->createPermissions('workSchedule', $managerRole);
        // $this->createPermissions('settings', $managerRole, ['update']);
        $this->createPermissions('deliveryArea', $managerRole);
        $this->createPermissions('foodCategory', $managerRole);
        $this->createPermissions('food', $managerRole);
        $this->createPermissions('foodExtra', $managerRole);
    }

    protected function clearRoles()
    {
        Role::query()->delete();
    }

    protected function createAdminUser($role)
    {
        $user = User::where('email', 'admin@admin.com')->first();
        if (!$user) {
            $user = User::create([
                'email' => 'admin@admin.com',
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]);
        }
        $user->assignRole($role);
    }

    protected function createManagerUser($role)
    {
        $user = User::where('email', 'manager@manager.com')->first();
        if (!$user) {
            $user = User::create([
                'email' => 'manager@manager.com',
                'name' => 'Manager',
                'password' => Hash::make('password'),
            ]);
        }
        $user->assignRole($role);
    }

    protected function createPermissions($modelName, $role, $permissions = ["create", "read", "update", "delete"])
    {
        foreach ($permissions as $type) {
            $permission = Permission::firstOrCreate(['name' => "$modelName:$type"]);
            $role->givePermissionTo($permission);
        }
    }
}
