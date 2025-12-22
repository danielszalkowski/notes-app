<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Office::create([
            'id' => 1,
            'name' => 'Oficina Central Valencia',
            'address' => 'Calle del Turia, 10',
        ]);

        Office::create([
            'id' => 2,
            'name' => 'Oficina Secundaria Madrid',
            'address' => 'Calle de Prueba, 20',
        ]);
    }
}
