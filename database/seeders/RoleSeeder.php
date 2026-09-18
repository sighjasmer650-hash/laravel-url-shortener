<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'SuperAdmin',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'Member',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'Sales',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'Manager',
            'guard_name' => 'web',
        ]);
    }
}

