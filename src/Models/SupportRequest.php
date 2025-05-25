<?php

namespace App\Models;

use App\Core\Config\Config;
use App\Core\DataBase\DataBase;
use JetBrains\PhpStorm\NoReturn;

class SupportRequest extends DataBase
{
    public function __construct()
    {
        $config = new Config();
        parent::__construct($config);
    }

    public function getCountAllRequest(): int
    {
        $sql ="SELECT COUNT(*) as total FROM $this->table";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn()??0;
    }

    public function getCountUnprocessedRequest(): int
    {
        $sql = "SELECT COUNT(*) as total FROM $this->table WHERE processed = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn()??0;
    }

    private $table = 'support_request';

    #[NoReturn] public function addRequest( int $id_user, string $header_request , string $body_request): void
    {
        $sql = "INSERT INTO $this->table (id_user, header_request, body_request, created_at) VALUES (:id_user, :header_request, :body_request, :created_at)";
        $time=time();
        $stmt=$this->pdo->prepare($sql);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':header_request', $header_request);
        $stmt->bindParam(':body_request', $body_request);
        $stmt->bindParam(':created_at', $time);
        $stmt->execute();

    }

    public function deleteRequest(int $id):void
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
    public function getPaginationSupportRequest(int $page = 1, int $perPage = 10, string $search = ''): array
    {
         return $this->getPaginated($this->table, $page, $perPage, $search, ['id','login']);
    }

    #[NoReturn] public function setAnswer(int $id, int $admin_id ,string $header_answer, string $body_answer): void
    {
        $sql = "UPDATE $this->table 
        SET id_admin = :id_admin, 
            header_answer = :header_answer, 
            body_answer = :body_answer, 
            processed = :processed 
        WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_admin', $admin_id);
        $stmt->bindParam(':header_answer', $header_answer);
        $stmt->bindParam(':body_answer', $body_answer);
        $i = 1; // true
        $stmt->bindParam(':processed', $i);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }


    public function getUserPaginationSupportRequest(int $page = 1, int $perPage = 10, int $user_id): array
    {
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT * FROM support_request";
        $countSql = "SELECT COUNT(*) FROM support_request";
        $params = [];
        $where = "";

        if (!empty($search)) {
            $where = " WHERE (user_id =:user_id)";

        } else {
            $where = ' ';
        }

        $sql .= $where . " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $countSql .= $where;
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        $supportRequests = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare($countSql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $total = (int)$stmt->fetchColumn();

        return [
            'supportRequests' => $supportRequests,
            'total' => $total,
            'total_pages' => ceil($total / $perPage),
            'current_page' => $page
        ];
    }

}