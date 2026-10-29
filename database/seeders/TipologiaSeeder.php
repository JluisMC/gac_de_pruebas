<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tipologia;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class TipologiaSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // Vaciar la tabla usando el modelo
        Tipologia::truncate();
        Schema::enableForeignKeyConstraints();

        // Matriz de combinaciones únicas extraídas del Excel
        $jerarquia = [
            'CONSULTA' => [
                'SERVICIOS' => [
                    'PERSONALIZACION DE LINEA',
                    'SERVICIO VALOR AGREGADO',
                    'SERVICIO VALOR AGREGADO/ OTROS',
                    'SERVICIO VALOR AGREGADO/ TIGO SPORT',
                    'SERVICIOS SUPLEMENTARIOS',
                    'VOLTE',
                    'PASAR O PEDIR SALDO',
                    'USSD',
                    'ESIM',
                    'FORMAS DE PAGO',
                    'PUNTOS DE PAGO',
                    'FORMAS DE PAGO',
                    'ADELANTO DE SALDO',
                ],
                'CONSUMO' => [
                    'PAQUETES - BONOS',
                    'MINUTOS-SALDO',
                    'MINUTOS - SALDO',
                    'ADELANTO DE SALDO',
                    'PAQUETES DE LARGA DISTANCIA INTERNACIONAL'
                ],
                'PORTABILIDAD' => [
                    'TASA MENSUAL POR PORTABILIDAD',
                    'REQUISITOS',
                ],
                'ATENCION' => [
                    'ATENCION POR OTROS CANALES DE ATENCION',
                    'HORARIOS DE ATENCION',
                    'DIRECCIONES DE TIENDAS',
                    'ACTIVACION-RECARGA DE LINEA',
                    'FIDELIZACION',
                    'ATENCION POR OTROS CANALES DE ATENCION - En seguimiento',
                ],
                'SERVICIO TECNICO' => [
                    'SERVICIO VALOR AGREGADO',
                    'ESTADO DE EQUIPO EN REPARACION',
                ],
                'ROAMING' => [
                    'OFERTA',
                    'COBERTURA',
                    'COSTO DE LLAMADAS',
                    'CONSUMO',
                ],
                'TERMINALES' => [
                    'REQUISITOS PARA LLEVAR EQUIPO EN CUOTAS',
                    'PRECIO',
                    'FUNCIONAMIENTO TERMINAL',
                ],
                'FACTURACION' => [
                    'AUMENTO DE PRECIO',
                    'EXPLICACION DE FACTURA',
                    'MONTO A CANCELAR',
                    'ENVIO DE FACTURA',
                ],
                'OFERTA' => [
                    'PROMOCIONES',
                    'PLAN LIBRE ILIMITADO',
                    'PLANES',
                    'PAQUETES - BONOS',
                    'PLANES PREPAGO',
                ],
                'COBERTURA' => [
                    'RED 3G-4G',
                ],
            ],
            'RECLAMO' => [
                'DATA' => [
                    'NO PUEDE NAVEGAR O ACCEDER A INTERNET',
                    'EXEPCION DE BONO ILIMITADO',
                    'APNS',
                    'COMPARTIR DATA HOTSPOT',
                ],
                'RECARGA' => [
                    'PIN BORROSO',
                    'NO LLEGA LA RECARGA POR BANCA EN LINEA',
                ],
                'FACTURACION' => [
                    'PLAN MENSUAL MAL FACTURADO',
                    'ERROR DE BENEFICIO',
                ],
                'RIESGO' => [
                    'PROMOCIONES FALSAS',
                    'FUGA DE INFORMACION',
                    'FRAUDE DEL VENDEDOR',
                    'FRAUDE DEL CLIENTE',
                    'MALA GESTION DE VENTA',
                ],
                'SERVICIOS' => [
                    'NO PUEDE INGRESAR AL BUZON DE VOZ',
                    'NO PUEDE ENVIAR O RECIBIR SMS',
                ],
                'RED' => [
                    'FALLAS DE COBERTURA',
                    'CONGESTION DE RED',
                ],
                'COMUNICACIÓN' => [
                    'NO PUEDE HACER O RECIBIR LLAMADAS LOCALES',
                    'INCONVENIENTE CON NUMERO CORTO - VPN',
                ],
                'SMS' => [
                    'NO RECIBE SMS DE CONFIRMACION',
                    'NO DESEA RECIBIR SMS PROMOCIONALES',
                    'NO RECIBE SMS DE AUTENTICACION DE APPS EXTERNAS',
                ],
                'ROAMING' => [
                    'INCONVENIENTE CON VOZ',
                    'INCONVENIENTE CON DATA',
                    'DATA LENTA (THROTTELING)',
                ],
            ],
            'TRAMITE' => [
                'AJUSTE' => [
                    'RECARGA - DECREMENTAL',
                    'RECARGA - INCREMENTAL',
                    'BONOS PAQUETE COMPRADO',
                    'EXEPCION DE BONO ILIMITADO',
                ],
                'SERVICIOS' => [
                    'ACT-DES DE SERVICIOS SUPLEMENTARIOS',
                    'PERSONALIZACION DE LINEA',
                    'CAMBIO DE SIMCARD POR PERDIDA - ROBO',
                    'CAMBIO DE SIMCARD POR ESIM',
                    'CAMBIO DE SIMCARD POR DAÑO',
                    'DENUNCIA POR ROBO',
                ],
                'FACTURACION' => [
                    'ENVIO DE FACTURA POR EMAIL',
                    'ENVIO DE FACTURA',
                    'FACTURACION MISCELÁNEA (CREACION)',
                ],
                'DESCONEXIONES' => [
                    'ANULACION DE BAJA',
                    'OPTA PREPAGO',
                    'BAJA TOTAL DE LA CUENTA',
                ],
                'RECAUDACION' => [
                    'RECLASIFICACION DE PAGO',
                    'PAGOS NO APLICADOS EN SISTEMA',
                    'PAGO ERRADO MOVIL EN FIJO',
                    'PAGO ERRADO FIJO EN MOVIL',
                ],
                'VENTA' => [
                    'MIGRACION DE PRODUCTO',
                    'ADQUISICION DE PAQUETES',
                    'VENTA CROSS SELLING',
                    'ADQUISICION DE CONTRATO',
                    'VENTA NO COMPLETADA'

                ],
                'ROAMING' => [
                    'DESACTIVACION DE SERVICIO',
                    'ACTIVACION DE SERVICIO',
                ],
                'DATA ILIMITADA' => [
                    'ALTA',
                    'BAJA',
                ],
                'COBROS' => [
                    'ARREGLO DE PAGO',
                ],
            ],
        ];

        // Recorrido automático e inserción de jerarquía
        foreach ($jerarquia as $nivel1Nombre => $categorias) {
            $n1 = Tipologia::firstOrCreate([
                'nombre' => $nivel1Nombre,
                'nivel'  => 1,
                'parent_id' => null,
            ]);

            foreach ($categorias as $nivel2Nombre => $tipologias) {
                $n2 = Tipologia::firstOrCreate([
                    'nombre' => $nivel2Nombre,
                    'nivel'  => 2,
                    'parent_id' => $n1->id,
                ]);

                foreach ($tipologias as $nivel3Nombre) {
                    Tipologia::firstOrCreate([
                        'nombre' => $nivel3Nombre,
                        'nivel'  => 3,
                        'parent_id' => $n2->id,
                    ]);
                }
            }
        }
    }
}
