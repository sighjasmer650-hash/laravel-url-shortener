<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | SuperAdmin
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

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
            3,
            'Admin User',
            'admin@gmail.com',
            Hash::make('admin@123'),
            'Admin',
            now(),
            now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Member
        |--------------------------------------------------------------------------
        */

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
            3,
            'Member User',
            'member@gmail.com',
            Hash::make('member@123'),
            'Member',
            now(),
            now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Sales
        |--------------------------------------------------------------------------
        */

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
            3,
            'Sales User',
            'sales@gmail.com',
            Hash::make('sales@123'),
            'Sales',
            now(),
            now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Manager
        |--------------------------------------------------------------------------
        */

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
            3,
            'Manager User',
            'manager@gmail.com',
            Hash::make('manager@123'),
            'Manager',
            now(),
            now(),
        ]);
    }
}