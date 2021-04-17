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
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $this->createAdminUser($adminRole);
        $this->createPermissions('user', $adminRole);
        $this->createPermissions('workSchedule', $adminRole);
    }

    protected function createAdminUser($role)
    {
        $user = User::firstOrCreate([
            'email' => 'admin@admin.com',
        ]);
        $user->name = "Admin";
        $user->password = Hash::make('password');
        $user->save();
        $user->assignRole($role);
        return $user;
    }

    protected function createPermissions($modelName, $role, $permissions = [
        "create" => true,
        "read" => true,
        "update" => true,
        "delete" => true,
    ]) {
        foreach ($permissions as $type => $active) {
            if ($active) {
                $permission = Permission::firstOrCreate(['name' => "$modelName:$type"]);
                $role->givePermissionTo($permission);
            }
        }
    }
}
