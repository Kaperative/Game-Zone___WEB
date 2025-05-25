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
        return $result = $this->getPaginated($this->table, $page, $perPage, $search, ['id']);
    }

   public function createUser(int $id_user, string $content, string $header, string $tag): bool
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

   public function getCountArticles(): int
   {
       $sql = "SELECT COUNT(*) as total FROM $this->table";
       $stmt = $this->pdo->prepare($sql);
       $stmt->execute();
       return $stmt->fetchColumn()??0;

   }
}
