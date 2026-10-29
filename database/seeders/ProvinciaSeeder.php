<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Provincia;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProvinciaSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // Vaciar la tabla usando el modelo
        Provincia::truncate();
        Schema::enableForeignKeyConstraints();

        Provincia::insert([
            ['nombre' => 'Panamá'],
            ['nombre' => 'Panamá Oeste'],
            ['nombre' => 'Colón'],
            ['nombre' => 'Chiriquí'],
            ['nombre' => 'Coclé'],
            ['nombre' => 'Herrera'],
            ['nombre' => 'Los Santos'],
            ['nombre' => 'Veraguas'],
            ['nombre' => 'Darién'],
            ['nombre' => 'Bocas del Toro'],
            ['nombre' => 'Comarca Emberá Wounaan'],
            ['nombre' => 'Comarca Guna De Madugandi'],
            ['nombre' => 'Comarca Guna de Wargandi'],
            ['nombre' => 'Comarca Guna Yala'],
            ['nombre' => 'Comarca Ngábe Buglé'],
        ]);
    }
}
