<?php

namespace App\Models;

use App\Core\Config\Config;
use App\Core\DataBase\DataBase;

class AdminLog extends  DataBase
{
    private string $table = 'admin_logs';
    public function __construct()
    {
        $config= new Config();
        parent::__construct($config);
    }

    public function logAction(int $adminId, string $action, string $entityType, ?int $entityId = null, ?string $details = null): void
    {
        $data= [
            'admin_id' => $adminId,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'details' => $details,
        ];
        $this->insert($this->table,$data);
    }

    public function getPaginatedLogs(int $page = 1, int $perPage = 20,string $search = ''): array
    {
        return $result = $this->getPaginated($this->table, $page, $perPage, $search, ['id','action']);
    }

}