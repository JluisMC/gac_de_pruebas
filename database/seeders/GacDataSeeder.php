<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cuenta;
use App\Models\Cliente;
use App\Models\Abonado;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class GacDataSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // Vaciar la tabla usando el modelo
        Cliente::truncate();
        Cuenta::truncate();
        Abonado::truncate();
        Schema::enableForeignKeyConstraints();

        $faker = Faker::create('es_PA');

        Cuenta::factory(500)->create()->each(function ($cuenta) use ($faker) {

            // 1. CLIENTE PRINCIPAL
            $clientePrincipal = Cliente::factory()->make();

            $nombrePersonaResponsable = $clientePrincipal->nombre_cliente;
            $cuenta->clientes()->save($clientePrincipal);

            $categoriaCuenta = $faker->randomElement(['prepago', 'individual', 'pyme']);

            if ($categoriaCuenta === 'prepago') {
                // --- REGLAS PREPAGO ---
                $cantidadAbonados = 1;
                $cuenta->tipo_cuenta = 'PREPAGO';
                $clientePrincipal->ciclo_facturacion = 'PREPAGO';

                $esGenerico = $faker->boolean(50);

                if ($esGenerico) {
                    $nombreGenerico = $faker->randomElement(['Generico 15', 'Generico 20', 'Movil Phone']);
                    $cedulaSinGuiones = (string) rand(11111111, 18999999);

                    $clientePrincipal->nombre_cliente    = $nombreGenerico;
                    $clientePrincipal->identificacion    = $cedulaSinGuiones;
                    $cuenta->nombre_cuenta      = $nombreGenerico;
                    $cuenta->responsable_cuenta = $nombreGenerico;
                    $cuenta->identificacion     = $cedulaSinGuiones;
                } else {
                    $cedulaConGuiones = rand(1, 9) . '-' . rand(100, 999) . '-' . rand(1000, 9999);

                    $clientePrincipal->identificacion    = $cedulaConGuiones;
                    $cuenta->nombre_cuenta      = $clientePrincipal->nombre_cliente;
                    $cuenta->responsable_cuenta = $clientePrincipal->nombre_cliente;
                    $cuenta->identificacion     = $cedulaConGuiones;
                }
            } elseif ($categoriaCuenta === 'individual') {
                // --- REGLAS PLANES INDIVIDUALES ($27, $30, $38) ---
                $cantidadAbonados = rand(1, 4);
                $cuenta->tipo_cuenta = 'Individual';
                $clientePrincipal->ciclo_facturacion = $faker->randomElement(['CICLO 4', 'CICLO 19']);

                $cedulaConGuiones = rand(1, 9) . '-' . rand(100, 999) . '-' . rand(1000, 9999);
                $clientePrincipal->identificacion    = $cedulaConGuiones;
                $cuenta->nombre_cuenta      = $clientePrincipal->nombre_cliente;
                $cuenta->responsable_cuenta = $clientePrincipal->nombre_cliente;
                $cuenta->identificacion     = $cedulaConGuiones;
            } else {
                // --- REGLAS PLANES CORPORATIVOS / PYME / EMPRESA ---
                $cantidadAbonados = rand(3, 5);
                $clientePrincipal->ciclo_facturacion = $faker->randomElement(['CICLO 4', 'CICLO 19']);

                $esCopa = $faker->boolean(40);

                if ($esCopa) {
                    $nombreCliente       = 'Asociados COPA';
                    $cuenta->tipo_cuenta = 'Empresa';
                    $responsableCuenta   = $nombrePersonaResponsable;
                } else {
                    $cuenta->tipo_cuenta = $faker->randomElement(['Pyme', 'Empresa']);

                    $esRazonSocial = $faker->boolean(50);

                    if ($esRazonSocial) {
                        $rubro  = $faker->randomElement(['Vidrieria', 'Inversiones', 'Comercializadora', 'Distribuidora', 'Servicios', 'Consultores', 'Grupo']);
                        $nombre = $faker->firstName();
                        $sufijo = $faker->randomElement(['S.A.', 'Inc.', 'Corp.', 'R.L.']);

                        $nombreCliente     = "{$rubro} {$nombre} {$sufijo}";
                        $responsableCuenta = $nombrePersonaResponsable;
                    } else {
                        $nombreCliente     = $clientePrincipal->nombre_cliente;
                        $responsableCuenta = $clientePrincipal->nombre_cliente;
                    }
                }

                $cedulaConGuiones = rand(1, 9) . '-' . rand(100, 999) . '-' . rand(1000, 9999);

                $clientePrincipal->nombre_cliente    = $nombreCliente;
                $clientePrincipal->identificacion    = $cedulaConGuiones;
                $cuenta->nombre_cuenta      = $nombreCliente;
                $cuenta->responsable_cuenta = $responsableCuenta;
                $cuenta->identificacion     = $cedulaConGuiones;
            }

            // Guardar cambios en Cliente Principal y Cuenta
            $clientePrincipal->save();
            $cuenta->save();

            // 2. CREAR ABONADOS DEL CLIENTE PRINCIPAL
            for ($i = 0; $i < $cantidadAbonados; $i++) {

                if ($categoriaCuenta === 'prepago') {
                    $planElegido = 'prepago';
                    $productoElegido = 'Prepago';
                    $situacion = $faker->randomElement([
                        'Alta Activa De Abonado',
                        'Suspensión Activa de Abonado',
                        'Baja Activa de Abonado',
                        'Plan Personalización'
                    ]);
                    $fechaExpiracion = null;
                } elseif ($categoriaCuenta === 'individual') {
                    // PLANES INDIVIDUALES EXCLUSIVOS
                    $planElegido = $faker->randomElement([
                        'Plan de $27',
                        'Plan de $30',
                        'Plan de $38',
                        'Plan de $43',
                        'Plan de $14.27',
                        'Plan de $16.94',
                        'Plan de $22.30',
                        'Plan de $25.87',
                        'Plan de $31.23',
                        'Plan de $40.16',
                        'Plan de $49.09',
                        'Plan de $58.02'
                    ]);
                    $productoElegido = $faker->randomElement(['Movil Hibrido', 'Movil Pospago']);
                    $situacion = $faker->randomElement([
                        'Alta Activa De Abonado',
                        'Suspensión Activa de Abonado',
                        'Baja Activa de Abonado'
                    ]);
                    $fechaExpiracion = now()->addYears(2)->format('Y-m-d');
                } else {
                    if ($clientePrincipal->nombre_cliente === 'Asociados COPA') {
                        $planElegido = 'Plan COPA $20';
                    } else {
                        $planElegido = $faker->randomElement(['Plan smart $15.99', 'Plan smart $20']);
                    }

                    $productoElegido = $faker->randomElement(['Movil Hibrido', 'Pospago']);
                    $situacion = $faker->randomElement([
                        'Alta Activa De Abonado',
                        'Suspensión Activa de Abonado',
                        'Baja Activa de Abonado'
                    ]);
                    $fechaExpiracion = now()->addYears(2)->format('Y-m-d');
                }

                $abonado = Abonado::factory()->make([
                    'cuenta_id'        => $cuenta->id,
                    'cliente_id'       => $clientePrincipal->id,
                    'plan_tarifario'   => $planElegido,
                    'producto'         => $productoElegido,
                    'situacion'        => $situacion,
                    'fecha_expiracion' => $fechaExpiracion,
                ]);

                $abonado->save();
            }

            // 3. MULTICLIENTE: SÓLO APLICA A CATEGORÍA 'INDIVIDUAL' (Planes $27, $30, $38)
            // Se excluyen Pyme, Empresa y COPA.
            if ($categoriaCuenta === 'individual' && $faker->boolean(50)) {

                $cantidadPrepagoExtra = rand(1, 2);

                for ($j = 0; $j < $cantidadPrepagoExtra; $j++) {

                    // Cada iteración crea un registro Cliente con un ID / Código de cliente totalmente nuevo
                    $clientePrepagoNuevo = Cliente::factory()->create([
                        'cuenta_id'         => $cuenta->id,
                        'nombre_cliente'    => $clientePrincipal->nombre_cliente,
                        'identificacion'    => $clientePrincipal->identificacion,
                        'ciclo_facturacion' => 'PREPAGO',
                    ]);

                    // Asignamos el abonado al nuevo cliente generado
                    Abonado::factory()->create([
                        'cuenta_id'        => $cuenta->id,
                        'cliente_id'       => $clientePrepagoNuevo->id,
                        'plan_tarifario'   => 'prepago',
                        'producto'         => 'Prepago',
                        'situacion'        => $faker->randomElement([
                            'Alta Activa De Abonado',
                            'Suspensión Activa de Abonado',
                            'Baja Activa de Abonado'
                        ]),
                        'fecha_expiracion' => null,
                    ]);
                }
            }
        });
    }
}
