<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::insert("
            INSERT INTO users
            (
                company_id,
                name,
                email,
                password,
                role,
                created_at,
                updated_at
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?)
        ", [
            null,
            'Super Admin',
            'superadmin@gmail.com',
            Hash::make('superadmin@123'),
            'SuperAdmin',
            now(),
            now(),
        ]);
    }
}