<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AbonadoFactory extends Factory
{
    public function definition(): array
    {
        $situaciones = [
            'Alta Activa De Abonado',
            'Suspensión Activa de Abonado',
            'Baja Activa de Abonado',
            'Plan Personalización'
        ];

        // 1. Elegir la situación primero
        $situacionElegida = $this->faker->randomElement($situaciones);

        // 2. REGLA CLAVE: Si la situación es "Plan Personalización", el plan DEBE ser "prepago"
        if ($situacionElegida === 'Plan Personalización') {
            $planElegido = 'prepago';
        } else {
            $planes = [
                'prepago',
                'Plan de $30',
                'Plan de $38',
                'Plan de $27',
                'Plan smart $15.99',
                'Plan smart $20',
                'Plan COPA $20'
            ];
            $planElegido = $this->faker->randomElement($planes);
        }

        // 3. Asignar el producto en función del plan tarifario
        if ($planElegido === 'prepago') {
            $producto = 'Prepago';
        } else {
            $producto = $this->faker->randomElement(['Movil Hibrido', 'Pospago']);
        }

        // 4. Fechas
        $fechaAlta = Carbon::instance($this->faker->dateTimeBetween('-1 years', 'now'));
        $fechaExp  = (clone $fechaAlta)->addYears(2);

        return [
            'situacion'        => $situacionElegida,
            'numero_abonado'   => $this->faker->unique()->numberBetween(20000000, 29999999),
            'numero_celular'   => '6' . $this->faker->numberBetween(1000000, 9999999),
            'codigo_usuario'   => $this->faker->numberBetween(10000000, 99999999),
            'numero_venta' => $this->faker->numberBetween(100000, 999999),
            'producto'         => $producto,
            'plan_tarifario'   => $planElegido,
            'tecnologia'       => 'GSM',
            'tipo_plan'        => '2G/3G',
            'tipo_simcard'     => 'LTE',
            'fecha_alta'       => $fechaAlta->format('Y-m-d'),
            'fecha_expiracion' => $fechaExp->format('Y-m-d'),
            'promocion'        => 'Ver Promociones',
            'recordatorio'     => 'El plan no aplica a LTE',
            'simcard'          => $this->faker->numberBetween(895000000, 895999999),
            'imei'             => $this->faker->numberBetween(350000000000000, 359999999999999),
            'modelo_equipo'    => $this->faker->randomElement(['Samsung A54', 'iPhone 11', 'Xiaomi Redmi 12']),
        ];
    }
}
