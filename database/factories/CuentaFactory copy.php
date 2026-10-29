<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CuentaFactory extends Factory
{
    public function definition(): array
    {
        // Generamos un tipo de cuenta por defecto para testing/seeders unitarios
        $tipoCuenta = $this->faker->randomElement(['PREPAGO', 'Individual', 'Empresa']);

        return [
            'numero_cuenta'      => $this->faker->unique()->numberBetween(4000000, 4999999),
            'nombre_cuenta'      => $this->faker->name(),
            'fecha_alta'         => $this->faker->date(),
            'tipo_cuenta'        => $tipoCuenta,
            'categoria'          => match ($tipoCuenta) {
                'PREPAGO'    => 'Prepago',
                'Individual' => 'Residencial',
                default      => 'Corporativo',
            },
            'vendedor'           => $this->faker->name() . ' (' . $this->faker->numberBetween(10000, 99999) . ')',
            'otros'              => 'Ver Servicios Contratados',
        ];
    }
}
