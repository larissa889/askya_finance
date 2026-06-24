<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Users\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ComptableSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'comptable@askya.com'],
            [
                'first_name' => 'Comptable',
                'last_name' => 'General',
                'email' => 'comptable@askya.com',
                'password' => Hash::make('comptable123'),
                'role' => UserRole::Comptable,
                'phone' => '+226 70 00 00 05',
                'is_active' => true,
            ]
        );

        $this->command->info('✓ Comptable créé avec succès : comptable@askya.com / comptable123');
    }
}
