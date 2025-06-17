<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;
use PDOException;

class CreateDatabase extends Command
{
    protected $signature = 'db:create';
    protected $description = 'Crie o banco de dados e os esquemas se eles não existirem';

    public function handle()
    {
        $this->info("INICIANDO -> CRIANDO DATABASE E SCHEMAS");

        $dbName = config('database.connections.pgsql.database');
        $dbHost = config('database.connections.pgsql.host');
        $dbPort = config('database.connections.pgsql.port');
        $dbUser = config('database.connections.pgsql.username');
        $dbPass = config('database.connections.pgsql.password');

        try {
            $pdo = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=postgres", $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->query("SELECT 1 FROM pg_database WHERE datname = '$dbName'");
            if (!$stmt->fetch()) {
                $pdo->exec("CREATE DATABASE \"$dbName\"");
                $this->info("Database '$dbName' created successfully.");
            } else {
                $this->info("Database '$dbName' already exists.");
            }

            $dbPdo = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
            $dbPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $schemas = ['auth', 'client', 'user', 'product'];

            foreach ($schemas as $schema) {
                $stmt = $dbPdo->query("SELECT schema_name FROM information_schema.schemata WHERE schema_name = '$schema'");
                if (!$stmt->fetch()) {
                    $dbPdo->exec("CREATE SCHEMA \"$schema\"");
                    $this->info("Schema '$schema' created.");
                } else {
                    $this->info("Schema '$schema' already exists.");
                }
            }

            $this->info("Processo finalizado com sucesso.");

        } catch (PDOException $e) {
            $this->error('Erro ao criar database ou schemas: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
