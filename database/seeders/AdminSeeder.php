<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Users\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer ou mettre à jour l'administrateur par défaut
        User::updateOrCreate(
            ['email' => 'admin@askya.com'],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@askya.com',
                'password' => Hash::make('admin123'),
                'role' => UserRole::Admin,
                'is_active' => true,
            ]
        );

        $this->command->info('✓ Administrateur créé avec succès : admin@askya.com / admin123');
    }
}
