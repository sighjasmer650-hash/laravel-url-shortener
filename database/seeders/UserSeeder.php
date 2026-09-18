<?php

namespace Database\Seeders;

use App\Models\User;
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
                created_at,
                updated_at
            )
            VALUES
            (?, ?, ?, ?, ?, ?)
        ", [
            null,
            'Super Admin',
            'superadmin@gmail.com',
            Hash::make('superadmin@123'),
            now(),
            now(),
        ]);

        $superAdmin = User::where(
            'email',
            'superadmin@gmail.com'
        )->first();

        $superAdmin->assignRole('SuperAdmin');


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
                created_at,
                updated_at
            )
            VALUES
            (?, ?, ?, ?, ?, ?)
        ", [
            3,
            'Admin User',
            'admin@gmail.com',
            Hash::make('admin@123'),
            now(),
            now(),
        ]);

        $admin = User::where(
            'email',
            'admin@gmail.com'
        )->first();

        $admin->assignRole('Admin');


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
                created_at,
                updated_at
            )
            VALUES
            (?, ?, ?, ?, ?, ?)
        ", [
            3,
            'Member User',
            'member@gmail.com',
            Hash::make('member@123'),
            now(),
            now(),
        ]);

        $member = User::where(
            'email',
            'member@gmail.com'
        )->first();

        $member->assignRole('Member');


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
                created_at,
                updated_at
            )
            VALUES
            (?, ?, ?, ?, ?, ?)
        ", [
            3,
            'Sales User',
            'sales@gmail.com',
            Hash::make('sales@123'),
            now(),
            now(),
        ]);

        $sales = User::where(
            'email',
            'sales@gmail.com'
        )->first();

        $sales->assignRole('Sales');


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
                created_at,
                updated_at
            )
            VALUES
            (?, ?, ?, ?, ?, ?)
        ", [
            3,
            'Manager User',
            'manager@gmail.com',
            Hash::make('manager@123'),
            now(),
            now(),
        ]);

        $manager = User::where(
            'email',
            'manager@gmail.com'
        )->first();

        $manager->assignRole('Manager');
    }
}
