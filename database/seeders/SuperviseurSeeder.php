<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\User;
use App\Modules\Users\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperviseurSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Récupérer l'agence Goughin
        $goughin = Agency::where('code', 'GOU')->first();
        
        if (!$goughin) {
            $this->command->error('Agence Goughin non trouvée pour le superviseur.');
            return;
        }

        User::updateOrCreate(
            ['email' => 'superviseur@askya.com'],
            [
                'first_name' => 'Superviseur',
                'last_name' => 'Goughin',
                'email' => 'superviseur@askya.com',
                'password' => Hash::make('superviseur123'),
                'role' => UserRole::Superviseur,
                'agency_id' => $goughin->id,
                'phone' => '+226 70 00 00 04',
                'is_active' => true,
            ]
        );

        $this->command->info('✓ Superviseur créé avec succès : superviseur@askya.com / superviseur123 (Agence: Goughin)');
    }
}
