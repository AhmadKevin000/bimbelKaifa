<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('1'),
                'role'     => 'admin',
            ]
        );

        $this->command->info('Admin user seeded: admin@gmail.com / 1');
    }
}
