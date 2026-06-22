<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'code' => 'WIZ',
                'name' => 'Wizall Money',
                'description' => 'Service de transfert d\'argent Wizall Money',
                'is_active' => true,
            ],
            [
                'code' => 'COR',
                'name' => 'Coris Money',
                'description' => 'Service de transfert d\'argent Coris Money',
                'is_active' => true,
            ],
            [
                'code' => 'OM',
                'name' => 'Orange Money',
                'description' => 'Service de monnaie électronique Orange Money',
                'is_active' => true,
            ],
            [
                'code' => 'MM',
                'name' => 'Moov Money',
                'description' => 'Service de monnaie électronique Moov Money',
                'is_active' => true,
            ],
            [
                'code' => 'TM',
                'name' => 'Telecel Money',
                'description' => 'Service de monnaie électronique Telecel Money',
                'is_active' => true,
            ],
            [
                'code' => 'WU',
                'name' => 'Western Union',
                'description' => 'Service de transfert d\'argent Western Union',
                'is_active' => true,
            ],
            [
                'code' => 'RIA',
                'name' => 'RIA',
                'description' => 'Service de transfert d\'argent RIA',
                'is_active' => true,
            ],
            [
                'code' => 'MGNK',
                'name' => 'MoneyGram NK',
                'description' => 'Service de transfert d\'argent MoneyGram NK',
                'is_active' => true,
            ],
            [
                'code' => 'WUNK',
                'name' => 'Western Union NK',
                'description' => 'Service de transfert d\'argent Western Union NK',
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
