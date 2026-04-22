<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'المدير العام',
                'password' => Hash::make('Admin@12345'),
                'role'     => 'super_admin',
            ]
        );
    }
}
