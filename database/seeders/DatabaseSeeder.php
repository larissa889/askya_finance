<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AgencySeeder::class,
            ServiceSeeder::class,
            OperationTypeSeeder::class,
            AgencyServiceSeeder::class,
            AdminSeeder::class,
            CashierSeeder::class,
            SuperviseurSeeder::class,
            ComptableSeeder::class,
        ]);
    }
}
