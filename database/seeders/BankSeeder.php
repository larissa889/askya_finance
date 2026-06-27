<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            [
                'name' => 'Orabank',
                'code' => 'ORA',
                'is_active' => true,
            ],
            [
                'name' => 'UBA',
                'code' => 'UBA',
                'is_active' => true,
            ],
            [
                'name' => 'BSIC',
                'code' => 'BSI',
                'is_active' => true,
            ],
        ];

        foreach ($banks as $bank) {
            Bank::updateOrCreate(
                ['code' => $bank['code']],
                $bank
            );
        }
    }
}
