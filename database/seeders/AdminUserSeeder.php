<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'software@gmail.com'],
            [
                'name' => 'Software Engineer',
                'password' => Hash::make('software123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'dataanalyst@gmail.com'],
            [
                'name' => 'Data Analyst',
                'password' => Hash::make('data123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'hrmanager@gmail.com'],
            [
                'name' => 'HR Manager',
                'password' => Hash::make('hr123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'qa@gmail.com'],
            [
                'name' => 'Quality Assurance',
                'password' => Hash::make('qa123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'productmanager@gmail.com'],
            [
                'name' => 'Product Manager',
                'password' => Hash::make('product123'),
            ]
        );
    }
}