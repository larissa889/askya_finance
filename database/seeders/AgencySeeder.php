<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agencies = [
            [
                'code' => 'GOU',
                'name' => 'Goughin',
                'address' => 'Ouagadougou, Goughin',
                'phone' => '+226 70 00 00 00',
                'email' => 'goughin@askya-finance.bf',
                'manager' => 'Directeur Goughin',
                'cash_balance' => 0,
                'electronic_balance' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'OUA',
                'name' => 'Ouaga 2000',
                'address' => 'Ouagadougou, Ouaga 2000',
                'phone' => '+226 70 00 00 01',
                'email' => 'ouaga2000@askya-finance.bf',
                'manager' => 'Directeur Ouaga 2000',
                'cash_balance' => 0,
                'electronic_balance' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'SOM',
                'name' => 'Somgandé',
                'address' => 'Ouagadougou, Somgandé',
                'phone' => '+226 70 00 00 02',
                'email' => 'somgande@askya-finance.bf',
                'manager' => 'Directeur Somgandé',
                'cash_balance' => 0,
                'electronic_balance' => 0,
                'is_active' => true,
            ],
        ];

        foreach ($agencies as $agency) {
            Agency::create($agency);
        }
    }
}
