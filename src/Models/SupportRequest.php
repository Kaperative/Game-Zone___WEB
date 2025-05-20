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

    private $table = 'supportRequests';

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
        $offset = ($page - 1) * $perPage;

        // Базовый запрос
        $sql = "SELECT * FROM supportRequests";
        $countSql = "SELECT COUNT(*) FROM supportRequests";
        $params = [];
        $where = "";

        // Добавляем поиск если нужно
        if (!empty($search)) {
            $where = " WHERE header_request LIKE :search";
            if (is_numeric($search)) {
                $where .= " OR id = :id";
                $params[':id'] = (int)$search;
            }
            $params[':search'] = "%$search%";
        }

        $sql .= $where . " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $countSql .= $where;

        // Получаем данные
        $stmt = $this->pdo->prepare($sql);

        // Привязываем параметры пагинации
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

        // Привязываем параметры поиска
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        $supportRequests = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Получаем общее количество
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