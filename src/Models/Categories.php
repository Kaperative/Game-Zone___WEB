<?php

namespace App\Models;

use App\Core\Config\Config;
use App\Core\DataBase\DataBase;

class Categories extends DataBase
{

    private string $table = "categories";

    public function __construct()
    {
        $config= new Config();
        parent::__construct($config);
    }
    public function getPaginatedCategorie(int $page = 1, int $perPage = 10, string $search = ''): array|false
    {
        return $result = $this->getPaginated($this->table, $page, $perPage, $search, ['name']);
    }

    public function createCategorie(array $data): void
    {
        $this->create($this->table,$data);
    }

    public function getCountCategorie(): int
    {
        return   $this->getCount($this->table);
    }

    public function deleteCategorie(int $id): void
    {
        $this->deleteById($this->table,$id);
    }
}