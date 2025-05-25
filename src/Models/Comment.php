<?php

namespace App\Models;

use App\Core\DataBase\DataBase;
use JetBrains\PhpStorm\NoReturn;


class Comment extends DataBase
{
    #[NoReturn] public function  createUser(int $id_user, string $content): void
    {
        $sql= "INSERT INTO comments (id_user, content,created_at,updated_at) VALUES(:id_user, :content,:created_at,:updated_at)";
        $stmt = $this->pdo->prepare($sql);
        $time= time();
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':created_at', $time);
        $stmt->bindParam(':updated_at', $time);
        $stmt->execute();
    }

    #[NoReturn] public function deleteComment(int $id): void
    {
        $sql = "DELETE FROM comments WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    


}