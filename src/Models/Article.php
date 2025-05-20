<?php

namespace App\Models;

use App\Core\Config\Config;
use App\Core\DataBase\DataBase;

class Article extends DataBase
{

    private string $table = 'articles';

    public function __construct()
    {
        $config= new Config();
        parent::__construct($config);
    }

    public function getPaginatedArticles(int $page = 1, int $perPage = 10, string $search = ''): array|false
    {

        $offset = ($page - 1) * $perPage;

        // Базовый запрос
        $sql = "SELECT * FROM articles";
        $countSql = "SELECT COUNT(*) FROM articles";
        $params = [];

        if (!empty($search)) {
            $where = " WHERE header LIKE :search OR id = :id";
            $sql .= $where;
            $countSql .= $where;
            $params = [
                'search' => "%$search%",
                'id' => is_numeric($search) ? (int)$search : -1
            ];
        }


        $sql .= " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";

        // Получаем пользователей
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Получаем общее количество
        $stmt = $this->pdo->prepare($countSql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $total = (int)$stmt->fetchColumn();

        return [
            'articles' => $users,
            'total' => $total,
            'total_pages' => ceil($total / $perPage)
        ];
    }

   public function create($id_user,$content,$header,$tag): bool
   {
    $sql="INSERT INTO {$this->table} (id_user,header,content,created_at,updated_at,tag) VALUES (:id_user, :header, :content, :created_at, :updated_at, :tag);";
    $stmt = $this->pdo->prepare($sql);
    $timeNow = time();
    $stmt->bindParam(':id_user', $id_user);
$stmt->bindParam(':header', $header);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':created_at', $timeNow);
    $stmt->bindParam(':updated_at', $timeNow);
    $stmt->bindParam(':tag', $tag);
    return $stmt->execute();
   }

   public function deleteArticle(int $id): void
   {
       $sql = "DELETE FROM articles WHERE id = :id";
       $stmt = $this->pdo->prepare($sql);
       $stmt->bindParam(':id', $id);
       $stmt->execute();
   }
}
