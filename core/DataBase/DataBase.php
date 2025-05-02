<?php

namespace App\Core\DataBase;

use App\Core\Config\Config;
use PDO;

class DataBase
{
    protected Config $config;
    protected \PDO $pdo;

    public function __construct( Config $config )
    {
        $this->config = $config;
        $this->connect();
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function insert(string $table, array $data): bool
    {
        try {

            unset($data['id']);


            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));

            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);


            $result = $stmt->execute($data);

            if (!$result) {
                exit("DB Error: " . implode(" ", $stmt->errorInfo()));
                return false;
            }

            return (bool)$this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            exit("PDO Exception: " . $e->getMessage());
            return false;
        }
    }
   private function connect():void
   {
       $driver=$this->config->getConfig("configDB.driver");
       $host=$this->config->getConfig("configDB.host");
       $port=$this->config->getConfig("configDB.port");
       $dbname=$this->config->getConfig("configDB.dbname");
       $username=$this->config->getConfig("configDB.username");
       $password=$this->config->getConfig("configDB.password");
       $charset=$this->config->getConfig("configDB.charset");

       $this->pdo= new \PDO("$driver:host=$host;
                port =$port;
                dbname=$dbname;
                charset=$charset",
                username:$username,
                password:$password
       );
   }
}