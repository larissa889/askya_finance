<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Bank;
use App\Models\CashRegister;
use App\Models\User;
use Illuminate\Database\Seeder;

class CashRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Main Cash Registers for each Agency
        $agencies = Agency::all();
        foreach ($agencies as $agency) {
            CashRegister::updateOrCreate(
                ['code' => 'MAIN-' . $agency->code],
                [
                    'name' => 'Caisse Principale ' . $agency->name,
                    'code' => 'MAIN-' . $agency->code,
                    'type' => 'main',
                    'agency_id' => $agency->id,
                    'balance' => $agency->code === 'GOU' ? 5000000 : ($agency->code === 'OUA' ? 10000000 : 4000000),
                    'status' => 'closed',
                    'is_active' => true,
                ]
            );
        }

        // 2. Seed Bank Cash Registers for each Bank
        $banks = Bank::all();
        $goughin = Agency::where('code', 'GOU')->first();
        foreach ($banks as $bank) {
            CashRegister::updateOrCreate(
                ['code' => 'BANK-' . $bank->code],
                [
                    'name' => 'Compte ' . $bank->name,
                    'code' => 'BANK-' . $bank->code,
                    'type' => 'bank',
                    'agency_id' => $goughin ? $goughin->id : 1,
                    'bank_id' => $bank->id,
                    'balance' => $bank->code === 'ORA' ? 25000000 : ($bank->code === 'UBA' ? 35000000 : 15000000),
                    'status' => 'closed',
                    'is_active' => true,
                ]
            );
        }

        // 3. Seed Cashier's Cash Register for the default cashier
        $cashier = User::where('email', 'caissier@askya.com')->first();
        if ($cashier) {
            CashRegister::updateOrCreate(
                ['assigned_to' => $cashier->id],
                [
                    'code' => 'REG-' . $cashier->id . '-' . $cashier->agency->code,
                    'name' => 'Caisse de ' . $cashier->name,
                    'agency_id' => $cashier->agency_id,
                    'assigned_to' => $cashier->id,
                    'balance' => 100000,
                    'status' => 'open',
                    'opened_at' => now(),
                    'is_active' => true,
                ]
            );
        }
    }
}
