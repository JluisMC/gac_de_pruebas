<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class CopyMysqlToSqlite extends Command
{
    protected $signature = 'db:copy-mysql-to-sqlite';
    protected $description = 'Copia todos los datos de MySQL a la base de datos SQLite';

    public function handle()
    {
        $this->info('Iniciando transferencia de datos de MySQL a SQLite...');

        // Obtener la lista de tablas de SQLite
        $tables = DB::connection('sqlite')->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%';");

        foreach ($tables as $tableObj) {
            $tableName = $tableObj->name;

            // Omitir la tabla de migraciones para evitar conflictos
            if ($tableName === 'migrations') {
                continue;
            }

            $this->line("Copiando tabla: <comment>{$tableName}</comment>...");

            // Leer datos desde MySQL
            $data = DB::connection('mysql_source')->table($tableName)->get();

            if ($data->isNotEmpty()) {
                // Convertir cada elemento a array e insertarlo en SQLite
                $insertData = array_map(fn($item) => (array) $item, $data->toArray());

                // Insertar en bloques para no saturar memoria
                foreach (array_chunk($insertData, 500) as $chunk) {
                    DB::connection('sqlite')->table($tableName)->insert($chunk);
                }

                $this->info(" -> Se copiaron {$data->count()} registros.");
            } else {
                $this->warn(" -> Tabla vacía.");
            }
        }

        $this->info('¡Transferencia completada con éxito!');
    }
}
