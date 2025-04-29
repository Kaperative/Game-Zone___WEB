<?php

namespace App\Core;



class ConnectionDB {
    private ?PDO $connection;
    private array $errors;

    public function __construct(
        string $host, 
        string $port, 
        string $dbName, 
        string $user, 
        string $password
    ) {
        $this->errors = [];
        
        try {
            $this->connection = new PDO(
                "mysql:host={$host};port={$port};dbname={$dbName}", 
                $user, 
                $password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->errors["DataBase"] = "Error connection to database: " . $e->getMessage();
        }
    }

    public function getConnection(): ?PDO {
        return $this->connection;
    }

    public function getErrors(): array {
        return $this->errors;
    }
}