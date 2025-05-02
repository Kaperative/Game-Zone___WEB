<?php

namespace App\Core\DataBase\Model;

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

    public function getArticlesFromUserID(int $user_id,$count):array
    {
        $sql="SELECT * FROM articles WHERE id_user=? LIMIT ?";
        $stmt=$this->pdo->prepare($sql);
        $stmt->execute([$user_id,$count]);
        return $stmt->fetchAll();

    }

}
