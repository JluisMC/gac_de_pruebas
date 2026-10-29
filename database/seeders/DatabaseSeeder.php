<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Insertamos los 5 usuarios del sistema
        $usuarios = [
            [
                'name'     => 'Jose Mendez',
                'username' => 'outs_jomendez',
                'email'    => 'jomendez@tigo.com.pa',
                'password' => Hash::make('Telecel123*'),
                'grupo'    => 'CALLCENTER GT°',
            ],
        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }

        // Ejecutamos la carga de cuentas y abonados
        $this->call([
            GacDataSeeder::class,
            TipologiaSeeder::class,
            ProvinciaSeeder::class,
        ]);
    }
}
