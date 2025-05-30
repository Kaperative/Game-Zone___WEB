<?php

use App\Core\View\View;
use App\Models\User;
use App\services\AuthService;

/**
 * @var View $view
 * @var AuthService $auth
 * @var array $articles
 * @var array $columns
 * @var array $rows
 * @var string $tableName
 * @var bool $isAdmin
 * @var array $primary

 *
 // pagination
 * @var int $currentPage
 * @var int $totalPages
 * @var int $perPage
 * @var string $searchQuery
 */
?>

<style>
    .users-management-container {
        max-width: 1600px;
        margin: 30px auto;
        padding: 20px;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    .users-title {
        font-size: 28px;
        margin-bottom: 20px;
        color: #333;
    }

    .users-search {
        margin-bottom: 20px;
    }

    .search-form {
        display: flex;
        gap: 10px;
    }

    .search-form input[type="text"] {
        padding: 10px 14px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 6px;
        flex: 1;
    }

    .btn-search {
        padding: 10px 16px;
        background-color: #1a9fff;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.2s;
    }

    .btn-search:hover {
        background-color: #007ad6;
    }

    .table-header {
        background-color: #f1f7ff;
        border-radius: 8px 8px 0 0;
        padding: 12px 0;
        font-weight: bold;
        color: #1a9fff;
    }

    .table-body {
        border: 1px solid #eee;
        border-top: none;
        border-radius: 0 0 8px 8px;
        overflow: hidden;
    }

    .table-row {
        display: flex;
        padding: 14px 0;
        border-bottom: 1px solid #f0f0f0;
        transition: background-color 0.2s;
    }

    .table-row:hover {
        background-color: #f9fcff;
    }

    .table-cell {
        padding: 0 16px;
        display: flex;
        align-items: center;
        font-size: 14px;
        color: #444;
    }

    .table-cell:nth-child(1) { flex: 1; min-width: 60px; }
    .table-cell:nth-child(2) { flex: 2; min-width: 60px; }
    .table-cell:nth-child(3) { flex: 3; min-width: 200px; }
    .table-cell:nth-child(4) { flex: 2; min-width: 200px; }
    .table-cell:nth-child(5) { flex: 1.5; min-width: 100px; }
    .table-cell:nth-child(6) { flex: 3; min-width: 100px; }
    .table-cell:nth-child(7) { flex: 3; min-width: 100px; }
    .table-cell:nth-child(8) { flex: 3; min-width: 100px; }
    .table-cell:nth-child(9) { flex: 3; min-width: 100px; }
    .table-cell:nth-child(10) { flex: 3; min-width: 100px; }


    .status-badge {
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-badge.admin {
        background-color: #e8f5e9;
        color: #4caf50;
    }

    .status-badge.user {
        background-color: #e3f2fd;
        color: #1e88e5;
    }

    .actions-cell {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .btn-action {
        padding: 8px 12px;
        font-size: 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.2s;
    }

    .btn-action.grant {
        background-color: #4caf50;
        color: white;
    }

    .btn-action.grant:hover {
        background-color: #449944;
    }

    .btn-action.revoke {
        background-color: #f57c00;
        color: white;
    }

    .btn-action.revoke:hover {
        background-color: #e06600;
    }

    .btn-action.delete {
        background-color: #e53935;
        color: white;
    }

    .btn-action.delete:hover {
        background-color: #c62828;
    }

    .users-pagination {
        margin-top: 20px;
        text-align: center;
    }

    .page-link {
        display: inline-block;
        padding: 8px 12px;
        margin: 0 4px;
        background-color: #f1f1f1;
        color: #333;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.2s;
    }

    .page-link:hover {
        background-color: #e0e0e0;
    }

    .page-link.active {
        background-color: #1a9fff;
        color: white;
    }
    .users-table-wrapper {
        overflow-x: auto;
    }

    .users-table {
        min-width: 1000px;
    }

    .table-row {
        display: flex;
        flex-wrap: nowrap;
        border-bottom: 1px solid #f0f0f0;
        padding: 10px 0;
    }

    .table-cell {
        flex: 1;
        padding: 0 10px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .ellipsis {
        max-width: 300px;
    }

    @media (max-width: 768px) {
        .users-table {
            min-width: 800px;
        }

        .ellipsis {
            max-width: 150px;
        }
    }

</style>




<div class="users-management-container">
    <div class="users-header">
        <h1 class="users-title"><?=$tableName?></h1>
        <div class="users-search">
            <form method="get" class="search-form">
                <input type="text" name="search" placeholder="Поиск "
                       value="<?= htmlspecialchars($searchQuery ?? '') ?>">
                <button type="submit" class="btn-search">Найти</button>
            </form>
        </div>
        <?php if ($tableName !== 'admin_logs' && $tableName !== 'users'): ?>
        <button type="button" class="btn btn-primary open-form-btn"
                data-mode="add"
                data-table="<?=$tableName?>"
                data-primary='<?= json_encode($primary) ?>'
                data-fields='<?= json_encode($columns) ?>'>
            Добавить
        </button>
        <?php endif; ?>
    </div>


        <div class="users-table">
        <div class="table-header">
            <div class="table-row">
                <?php foreach ($columns as $col): ?>
                    <div class="table-cell"><?= htmlspecialchars($col) ?></div>
                <?php endforeach; ?>
                <?php if ($isAdmin) {?>
                <div class="table-cell">Действия</div>
                <?php } ?>
            </div>
        </div>


        <div class="table-body">
            <?php foreach ($rows as $row): ?>
                <div class="table-row">
                    <?php foreach ($columns as $col): ?>
                        <div class="table-cell ellipsis"><?= htmlspecialchars($row[$col] ?? '') ?></div>
                    <?php endforeach; ?>

                    <?php if ($isAdmin) {?>

                <div class="table-cell actions-cell">
                        <?php if (isset($row['id'])): ?>

                            <?php if ($tableName !== 'admin_logs'){ ?>
                            <form class="action-form" method="post" action="/admin/delete?id=<?= $row['id']?>&table=<?=$tableName?>"
                                  onsubmit="return confirm('Вы уверены, что хотите удалить это обращение?')">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn btn-danger">Удалить</button>
                            </form>

                            <button type="button" class="btn btn-primary open-form-btn"
                                    data-id="<?= $row['id'] ?>"
                                    data-mode="edit"
                                    data-table="<?=$tableName?>"
                                    data-primary='<?= json_encode($primary) ?>'
                                    data-values ='<?= json_encode($row)?>'
                                    data-fields='<?= json_encode($columns) ?>'>
                                Редактировать
                            </button>
                            <?php }?>
                        <?php if ($tableName === 'users'): ?>
                            <form method="post" action="/admin/<?= $row['isAdmin'] ? 'unsetAdmin' : 'setAdmin' ?>?user_id=<?=$row['id']?>" class="action-form">
                                <button type="submit" class="btn-action <?= $row['isAdmin'] ? 'revoke' : 'grant' ?>">
                                    <?= $row['isAdmin'] ? 'Снять админа' : 'Назначить админом' ?>
                                </button>
                            </form>

                            <?php elseif ($tableName === 'support_request'): ?>
                                <?php if (!$row['processed']):?>
                                <button type="button" class="btn btn-primary reply-btn-request"
                                        data-id="<?= htmlspecialchars($row['id'], ENT_QUOTES) ?>"
                                        data-header="<?= htmlspecialchars($row['header_request'], ENT_QUOTES) ?>"
                                        data-content="<?= htmlspecialchars($row['body_request'] ?? '', ENT_QUOTES) ?>">
                                    Ответить
                                </button>
                                <?php endif; ?>


                            <?php endif; ?>

                        <?php endif; ?>
                    </div>
                    <?php } ?>

                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?page=1&per_page=<?= $perPage ?>&search=<?= urlencode($searchQuery) ?>" class="page-link">Первая</a>
            <a href="?page=<?= $currentPage - 1 ?>&per_page=<?= $perPage ?>&search=<?= urlencode($searchQuery) ?>" class="page-link">Назад</a>
        <?php endif; ?>

        <?php for ($i = max(1, $currentPage - 2); $i <= min($currentPage + 2, $totalPages); $i++): ?>
            <a href="?page=<?= $i ?>&per_page=<?= $perPage ?>&search=<?= urlencode($searchQuery) ?>" class="page-link <?= $i == $currentPage ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage + 1 ?>&per_page=<?= $perPage ?>&search=<?= urlencode($searchQuery) ?>" class="page-link">Вперед</a>
            <a href="?page=<?= $totalPages ?>&per_page=<?= $perPage ?>&search=<?= urlencode($searchQuery) ?>" class="page-link">Последняя</a>
        <?php endif; ?>
    </div>

    <?php $view->includeComponent('/Pagination/defaultPagination');?>
</div>


<?php
    $view->includeScripts('/Universal/add');
if ($tableName === 'support_request')

{
    $view->includeScripts('/support/answer');
}?>

