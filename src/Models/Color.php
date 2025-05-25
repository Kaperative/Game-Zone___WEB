<?php

namespace App\Models;

use App\Core\Config\Config;
use App\Core\DataBase\DataBase;

class Color extends DataBase
{

    private string $table = "colors";

    public function __construct()
    {
        $config= new Config();
        parent::__construct($config);
    }
    public function getPaginatedColor(int $page = 1, int $perPage = 10, string $search = ''): array|false
    {
        return $result = $this->getPaginated($this->table, $page, $perPage, $search, ['name']);
    }

    public function createColor(array $data): void
    {
        $this->create($this->table,$data);
    }

    public function getCountColor(): int
    {
        return   $this->getCount($this->table);
    }

    public function deleteColor(int $id): void
    {
        $this->deleteById($this->table,$id);
    }
}