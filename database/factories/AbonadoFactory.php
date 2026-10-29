<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AbonadoFactory extends Factory
{
    public function definition(): array
    {
        // Por defecto configuraremos un plan Pospago / Híbrido con equipo
        $planes = [
            'Plan de $30',
            'Plan de $38',
            'Plan de $27',
            'Plan smart $15.99',
            'Plan smart $20',
            'Plan COPA $20'
        ];

        $planElegido = $this->faker->randomElement($planes);
        $producto = $this->faker->randomElement(['Movil Hibrido', 'Pospago']);
        $situacionElegida = $this->faker->randomElement([
            'Alta Activa De Abonado',
            'Suspensión Activa de Abonado',
            'Baja Activa de Abonado'
        ]);

        $fechaAlta = Carbon::instance($this->faker->dateTimeBetween('-4 years', 'now'));
        $fechaExp  = (clone $fechaAlta)->addYears(1);

        // 70% de probabilidad de equipo moderno en pospago, 30% sin equipo (Motorola V3)
        $tieneEquipo = $this->faker->boolean(70);

        return [
            'situacion'           => $situacionElegida,
            'numero_abonado'      => $this->faker->unique()->numberBetween(20000000, 29999999),
            'numero_celular'      => '6' . $this->faker->numberBetween(1000000, 9999999),
            'codigo_usuario'      => $this->faker->numberBetween(10000000, 99999999),
            'numero_venta'        => $this->faker->numberBetween(100000, 999999),
            'producto'            => $producto,
            'plan_tarifario'      => $planElegido,
            'tecnologia'          => 'GSM',
            'tipo_plan'           => '2G/3G',
            'tipo_simcard'        => 'LTE',
            'fecha_alta'          => $fechaAlta->format('Y-m-d'),
            'fecha_expiracion'    => $fechaExp->format('Y-m-d'),
            'promocion'           => 'Ver Promociones',
            'recordatorio'        => 'El plan no aplica a LTE',
            'simcard'             => $this->faker->numberBetween(895000000, 895999999),

            // Campos de Terminal (Pospago por defecto)
            'modelo_equipo'       => $tieneEquipo
                ? $this->faker->randomElement(['IPHONE 16 256GB BLACK', 'Samsung A54', 'Xiaomi Redmi 12'])
                : 'MOTOROLA V3',
            'imei'                => $tieneEquipo
                ? $this->faker->numberBetween(350000000000000, 359999999999999)
                : '00000000000010',
            'precio_regular'      => $tieneEquipo ? $this->faker->randomFloat(2, 500, 1500) : 0.00,
            'precio_venta'        => $tieneEquipo ? $this->faker->randomFloat(2, 400, 1200) : 0.00,
            'monto_subsidio'      => $tieneEquipo ? $this->faker->randomFloat(2, 50, 300) : 0.00,
            'asegurado'           => $tieneEquipo ? $this->faker->optional(0.3)->randomElement(['SI', 'NO']) : null,
            'siniestro'           => null,
            'fecha_cambio_equipo' => $tieneEquipo
                ? $this->faker->dateTimeBetween($fechaAlta, 'now')->format('Y-m-d')
                : $fechaAlta->format('Y-m-d'),
        ];
    }

    /**
     * Estado específico para abonados Prepago (Garantiza que NUNCA lleven equipo moderno)
     */
    public function prepago(): static
    {
        return $this->state(fn(array $attributes) => [
            'situacion'           => 'Plan Personalización',
            'producto'            => 'Prepago',
            'plan_tarifario'      => 'prepago',
            'fecha_expiracion'    => null,
            'modelo_equipo'       => 'MOTOROLA V3',
            'imei'                => '00000000000010',
            'precio_regular'      => 0.00,
            'precio_venta'        => 0.00,
            'monto_subsidio'      => 0.00,
            'asegurado'           => null,
            'fecha_cambio_equipo' => $attributes['fecha_alta'] ?? now()->format('Y-m-d'),
        ]);
    }
}
