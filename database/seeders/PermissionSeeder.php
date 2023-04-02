<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = ["create user", "update user", "delete user", "create post", "update post", "delete post"];
        foreach ($permissions as $key => $value) {
            Permission::create([
                "name" => $value
            ]);
        }
        $role = Role::first();
        $role->givePermissionTo($permissions);
    }
}