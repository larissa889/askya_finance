<?php

namespace Database\Seeders;

use App\Models\OperationType;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperationTypeSeeder extends Seeder
{
    public function run(): void
    {
        $services = Service::all()->keyBy('code');

        $operationTypes = [
            // Wizall Money
            ['service_id' => $services['WIZ']->id, 'code' => 'WIZ_CI', 'name' => 'Cash In', 'description' => 'Dépôt Wizall Money', 'is_active' => true],
            ['service_id' => $services['WIZ']->id, 'code' => 'WIZ_CO', 'name' => 'Cash Out', 'description' => 'Retrait Wizall Money', 'is_active' => true],
            
            // Coris Money
            ['service_id' => $services['COR']->id, 'code' => 'COR_DEP', 'name' => 'Dépôt', 'description' => 'Dépôt Coris Money', 'is_active' => true],
            ['service_id' => $services['COR']->id, 'code' => 'COR_RET', 'name' => 'Retrait', 'description' => 'Retrait Coris Money', 'is_active' => true],
            
            // Orange Money
            ['service_id' => $services['OM']->id, 'code' => 'OM_DEP', 'name' => 'Dépôt', 'description' => 'Dépôt Orange Money', 'is_active' => true],
            ['service_id' => $services['OM']->id, 'code' => 'OM_RET', 'name' => 'Retrait', 'description' => 'Retrait Orange Money', 'is_active' => true],
            
            // Moov Money
            ['service_id' => $services['MM']->id, 'code' => 'MM_DEP', 'name' => 'Dépôt', 'description' => 'Dépôt Moov Money', 'is_active' => true],
            ['service_id' => $services['MM']->id, 'code' => 'MM_RET', 'name' => 'Retrait', 'description' => 'Retrait Moov Money', 'is_active' => true],
            
            // Telecel Money
            ['service_id' => $services['TM']->id, 'code' => 'TM_DEP', 'name' => 'Dépôt', 'description' => 'Dépôt Telecel Money', 'is_active' => true],
            ['service_id' => $services['TM']->id, 'code' => 'TM_RET', 'name' => 'Retrait', 'description' => 'Retrait Telecel Money', 'is_active' => true],
            
            // Western Union
            ['service_id' => $services['WU']->id, 'code' => 'WU_ENV', 'name' => 'Envoi', 'description' => 'Envoi Western Union', 'is_active' => true],
            ['service_id' => $services['WU']->id, 'code' => 'WU_PAI', 'name' => 'Paiement', 'description' => 'Paiement Western Union', 'is_active' => true],
            
            // RIA
            ['service_id' => $services['RIA']->id, 'code' => 'RIA_ENV', 'name' => 'Envoi', 'description' => 'Envoi RIA', 'is_active' => true],
            ['service_id' => $services['RIA']->id, 'code' => 'RIA_PAI', 'name' => 'Paiement', 'description' => 'Paiement RIA', 'is_active' => true],
            
            // MoneyGram NK
            ['service_id' => $services['MGNK']->id, 'code' => 'MGNK_ENV', 'name' => 'Envoi', 'description' => 'Envoi MoneyGram NK', 'is_active' => true],
            ['service_id' => $services['MGNK']->id, 'code' => 'MGNK_PAI', 'name' => 'Paiement', 'description' => 'Paiement MoneyGram NK', 'is_active' => true],
            
            // Western Union NK
            ['service_id' => $services['WUNK']->id, 'code' => 'WUNK_ENV', 'name' => 'Envoi', 'description' => 'Envoi Western Union NK', 'is_active' => true],
            ['service_id' => $services['WUNK']->id, 'code' => 'WUNK_PAI', 'name' => 'Paiement', 'description' => 'Paiement Western Union NK', 'is_active' => true],
        ];

        foreach ($operationTypes as $operationType) {
            OperationType::create($operationType);
        }
    }
}
