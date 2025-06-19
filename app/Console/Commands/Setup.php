<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use PDO;
use PDOException;

class Setup extends Command
{
    protected $signature = 'app:setup';
    protected $description = 'Cria banco principal e de testes, schemas e executa migrations';

    protected string $connectionName = 'pgsql';
    protected array $schemas = ['client', 'public'];
    protected array $databases = [];

    public function handle(): int
    {
        $baseName = config("database.connections.{$this->connectionName}.database");
        $this->databases = [$baseName, "{$baseName}_test"];

        foreach ($this->databases as $dbName) {
            $this->info("Iniciando setup para banco: {$dbName}");

            try {
                $this->createDatabaseIfNotExists($dbName);
                $this->createSchemas($dbName);
                $this->runMigrations($dbName);
            } catch (PDOException $e) {
                $this->error("Erro no banco '{$dbName}': {$e->getMessage()}");
                return 1;
            }
        }

        $this->info("Setup finalizado para bancos: " . implode(', ', $this->databases));
        return 0;
    }

    private function createDatabaseIfNotExists(string $dbName): void
    {
        $host = config("database.connections.{$this->connectionName}.host");
        $port = config("database.connections.{$this->connectionName}.port");
        $user = config("database.connections.{$this->connectionName}.username");
        $pass = config("database.connections.{$this->connectionName}.password");

        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=postgres", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query("SELECT 1 FROM pg_database WHERE datname = '$dbName'");
        if (!$stmt->fetch()) {
            $pdo->exec("CREATE DATABASE \"$dbName\"");
            $this->info("Banco '$dbName' criado.");
        } else {
            $this->info("Banco '$dbName' já existe.");
        }
    }

    private function createSchemas(string $dbName): void
    {
        $host = config("database.connections.{$this->connectionName}.host");
        $port = config("database.connections.{$this->connectionName}.port");
        $user = config("database.connections.{$this->connectionName}.username");
        $pass = config("database.connections.{$this->connectionName}.password");

        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbName", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        foreach ($this->schemas as $schema) {
            $this->info("Verificando schema '{$schema}' em {$dbName}...");
            $stmt = $pdo->query("SELECT schema_name FROM information_schema.schemata WHERE schema_name = '$schema'");
            if (!$stmt->fetch()) {
                $pdo->exec("CREATE SCHEMA \"$schema\"");
                $this->info("Schema '$schema' criado.");
            } else {
                $this->info("Schema '$schema' já existe.");
            }
        }
    }

    private function runMigrations(string $dbName): void
    {
        $this->info("Rodando migrations para banco: {$dbName}...");

        $baseConnection = config("database.connections.{$this->connectionName}");
        $tempConnectionName = "{$this->connectionName}_{$dbName}";

        Config::set("database.connections.{$tempConnectionName}", [
            ...$baseConnection,
            'database' => $dbName,
        ]);

        // Roda migration usando a conexão temporária
        Artisan::call('migrate', [
            '--database' => $tempConnectionName,
            '--force' => true,
        ]);
        $this->info(Artisan::output());
    }
}
