<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'name' => 'Sembark Technologies',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tech Solutions Pvt Ltd',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Digital Innovations',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Smart Business Solutions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Global IT Services',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}