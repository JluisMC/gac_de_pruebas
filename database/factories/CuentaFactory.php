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

            // Nuevos campos para Dirección de Facturación y Cobranza
            'provincia'          => 'Panama',
            'distrito'           => 'Panama',
            'corregimiento'      => $this->faker->randomElement(['Bella Vista', 'San Francisco', 'Ancon', 'Bethania']),
            'calle'              => $this->faker->streetName(),
            'casa_apto'          => $this->faker->buildingNumber(),
            'estafeta'           => 'Correo Electrónico',
            'casilla'            => 'Re',
            'email'              => $this->faker->safeEmail(),

            // Nuevos campos para Información de Recaudación
            'saldo'              => $this->faker->randomFloat(2, 0, 300),
            'castigo_contable'   => $this->faker->randomFloat(2, 0, 500),
            'fecha_ultimo_pago'  => $this->faker->optional(0.8)->dateTimeBetween('-2 months', 'now')?->format('Y-m-d'),
            'monto_ultimo_pago'  => $this->faker->optional(0.8)->randomFloat(2, 10, 150),
        ];
    }
}
