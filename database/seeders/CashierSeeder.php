<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\User;
use App\Modules\Users\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CashierSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer l'agence Goughin
        $goughin = Agency::where('code', 'GOU')->first();
        
        if (!$goughin) {
            $this->command->error('Agence Goughin non trouvée. Assurez-vous que AgencySeeder a été exécuté.');
            return;
        }
        
        // Créer un caissier pour l'agence Goughin
        User::updateOrCreate(
            ['email' => 'caissier@askya.com'],
            [
                'first_name' => 'Caissier',
                'last_name' => 'Goughin',
                'email' => 'caissier@askya.com',
                'password' => Hash::make('caissier123'),
                'role' => UserRole::Caissier,
                'agency_id' => $goughin->id,
                'phone' => '+226 70 00 00 03',
                'is_active' => true,
            ]
        );

        $this->command->info('✓ Caissier créé avec succès : caissier@askya.com / caissier123 (Agence: Goughin)');
    }
}
