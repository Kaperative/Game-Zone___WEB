<?php

namespace App\Models;

use App\Core\Config\Config;
use App\Core\DataBase\DataBase;

class Brand extends DataBase
{

    private string $table = "brands";

    public function __construct()
    {
        $config= new Config();
        parent::__construct($config);
    }
    public function getPaginatedBrands(int $page = 1, int $perPage = 10, string $search = ''): array|false
    {
        return $result = $this->getPaginated($this->table, $page, $perPage, $search, ['name']);
    }

    public function createBrand(array $data): void
    {
        $this->create($this->table,$data);
    }

    public function getCountBrands(): int
    {
        return   $this->getCount($this->table);
    }

    public function deleteBrand(int $id): void
    {
        $this->deleteById($this->table,$id);
    }
}