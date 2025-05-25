<?php

namespace App\Core\DataBase;

use App\Core\Config\Config;
use PDO;

class DataBase
{
    protected Config $config;
    public \PDO $pdo;

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

    public function getCount(string $table): int
    {
        $sql = "SELECT COUNT(*) FROM {$table}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public function deleteById(string $table, int $id): bool
    {
        $sql = "DELETE FROM {$table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function create(string $table, array $data): bool
    {
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ':' . $col, $columns);

        $sql = "INSERT INTO {$table} (" . implode(',', $columns) . ") 
            VALUES (" . implode(',', $placeholders) . ")";

        $stmt = $this->pdo->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        return $stmt->execute();
    }


    public function getPaginated(
        string $table,
        int $page = 1,
        int $perPage = 10,
        string $search = '',
        array $searchColumns = ['name']
    ): array|false {
        $offset = ($page - 1) * $perPage;
        $params = [];

        $sql = "SELECT * FROM $table";
        $countSql = "SELECT COUNT(*) FROM $table";

        // Построение WHERE по колонкам
        if (!empty($search) && count($searchColumns) > 0) {
            $searchClauses = [];
            foreach ($searchColumns as $column) {
                if ($column === 'id' && is_numeric($search)) {
                    $searchClauses[] = "$column = :id";
                    $params['id'] = (int)$search;
                } else {
                    $searchClauses[] = "$column LIKE :search";
                }
            }
            $where = " WHERE " . implode(" OR ", $searchClauses);
            $sql .= $where;
            $countSql .= $where;

            if (!isset($params['search'])) {
                $params['search'] = "%$search%";
            }
        }

        $sql .= " LIMIT :limit OFFSET :offset";

        // Подготовка запроса
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Подсчёт общего количества
        $stmt = $this->pdo->prepare($countSql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $total = (int)$stmt->fetchColumn();

        return [
            'data' => $rows,
            'total' => $total,
            'total_pages' => ceil($total / $perPage),
            'page' => $page
        ];
    }

    function getImmutableColumns(string $table): array {
        $stmt = $this->pdo->prepare("
        SELECT COLUMN_NAME 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = DATABASE() 
          AND TABLE_NAME = :table 
          AND (COLUMN_KEY = 'PRI' OR COLUMN_KEY = 'UNI')
    ");
        $stmt->execute(['table' => $table]);
        return array_column($stmt->fetchAll(), 'COLUMN_NAME');
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