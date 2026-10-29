<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    public function definition(): array
    {
        $nombre = $this->faker->name();
        $cedula = $this->faker->numberBetween(1, 12) . '-' . $this->faker->numberBetween(10, 999) . '-' . $this->faker->numberBetween(100, 9999);

        return [
            'numero_cliente'    => $this->faker->unique()->numberBetween(5000000, 9999999),
            'nombre_cliente'    => $nombre,
            'identificacion'    => $cedula,
            'tipo_persona'      => $this->faker->randomElement(['Natural', 'Jurídica']),
            'categoria'         => $this->faker->randomElement(['VIP', 'Regular', 'Especial']),
            'telefono_contacto' => '6' . $this->faker->numberBetween(1000000, 9999999), // 8 dígitos iniciando en 6
            'saldo'             => $this->faker->randomFloat(2, 0, 150),
            'fecha_alta'        => $this->faker->date(),
        ];
    }
}
