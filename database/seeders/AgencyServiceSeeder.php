<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgencyServiceSeeder extends Seeder
{
    public function run(): void
    {
        $goughin = Agency::where('code', 'GOU')->first();
        $services = Service::all();

        // Associer tous les services à l'agence Goughin
        foreach ($services as $service) {
            $goughin->services()->attach($service->id, ['is_active' => true]);
        }
    }
}
