<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_user')->updateOrInsert(
            ['username' => 'admin'], // Kondisi: jika sudah ada admin
            [
                'level_id' => 1,
                'nama' => 'Administrator',
                'password' => Hash::make('admin123'), // Password default
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
