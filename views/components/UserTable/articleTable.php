<?php

use App\Core\View\View;
use App\Models\User;
use App\services\AuthService;

/**
 * @var View $view
 * @var AuthService $auth
 * @var array $articles
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
        <h1 class="users-title">Управление пользователями</h1>
        <div class="users-search">
            <form method="get" class="search-form">
                <input type="text" name="search" placeholder="Поиск по логину или ID"
                       value="<?= htmlspecialchars($searchQuery ?? '') ?>">
                <button type="submit" class="btn-search">Найти</button>
            </form>
        </div>
    </div>


    <div style="margin-bottom: 20px;">
        <button id="add-article-btn" class="btn-action grant">Добавить статью</button>
    </div>

    <div id="article-form-container" style="display: none; margin-bottom: 30px;">
        <form id="article-form" method="post" action="/admin/save-article">
            <input type="hidden" name="id" id="article-id">
            <div style="margin-bottom: 10px;">
                <input type="text" name="header" id="article-header" placeholder="Заголовок" style="width: 100%; padding: 10px;">
            </div>
            <div style="margin-bottom: 10px;">
                <textarea name="content" id="article-content" placeholder="Содержимое" style="width: 100%; padding: 10px; height: 100px;"></textarea>
            </div>
            <div style="margin-bottom: 10px;">
                <input type="text" name="tag" id="article-tag" placeholder="Тег" style="width: 100%; padding: 10px;">
            </div>
            <div>
                <button type="submit" class="btn-action grant">Сохранить</button>
                <button type="button" id="cancel-article-btn" class="btn-action delete">Отмена</button>
            </div>
        </form>
    </div>


    <div class="users-table-wrapper">
        <div class="users-table">
            <div class="table-header">
                <div class="table-row">
                    <div class="table-cell">ID</div>
                    <div class="table-cell">ID_USER</div>
                    <div class="table-cell">Заголовок</div>
                    <div class="table-cell">Содержимое</div>
                    <div class="table-cell">Лайки</div>
                    <div class="table-cell">Дизлайки</div>
                    <div class="table-cell">created_at</div>
                    <div class="table-cell">updated_at</div>
                    <div class="table-cell">tag</div>
                    <div class="table-cell">Действия</div>
                </div>
            </div>

            <div class="table-body">
                <?php foreach ($articles as $article): ?>
                    <div class="table-row">
                        <div class="table-cell"><?= $article['id'] ?></div>
                        <div class="table-cell"><?= $article['id_user'] ?></div>
                        <div class="table-cell"><?= htmlspecialchars($article['header']) ?></div>
                        <div class="table-cell ellipsis"><?= htmlspecialchars($article['content']) ?></div>
                        <div class="table-cell"><?= htmlspecialchars($article['likes']) ?></div>
                        <div class="table-cell"><?= htmlspecialchars($article['dislikes']) ?></div>
                        <div class="table-cell"><?= date('Y-m-d', $article['created_at']) ?></div>
                        <div class="table-cell"><?= date('Y-m-d', $article['updated_at']) ?></div>
                        <div class="table-cell"><?= htmlspecialchars($article['tag']) ?></div>
                        <div class="table-cell actions-cell">
                            <?php if ($article['id']): ?>
                                <form method="post" action="/admin/delete-article?article_id=<?= $article['id'] ?>"
                                      onsubmit="return confirm('Вы уверены, что хотите удалить этого пользователя?')">
                                    <button type="submit" class="btn-action delete">Удалить</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php $view->includeComponent('/Pagination/defaultPagination');?>
</div>
<script>
    const addBtn = document.getElementById('add-article-btn');
    const cancelBtn = document.getElementById('cancel-article-btn');
    const formContainer = document.getElementById('article-form-container');
    const form = document.getElementById('article-form');
    const idField = document.getElementById('article-id');
    const headerField = document.getElementById('article-header');
    const contentField = document.getElementById('article-content');
    const tagField = document.getElementById('article-tag');

    // Очистка формы
    function clearForm() {
        idField.value = '';
        headerField.value = '';
        contentField.value = '';
        tagField.value = '';
    }

    // Показ формы для добавления
    addBtn.addEventListener('click', () => {
        clearForm();
        formContainer.style.display = 'block';
        form.scrollIntoView({ behavior: 'smooth' });
    });

    // Отмена
    cancelBtn.addEventListener('click', () => {
        formContainer.style.display = 'none';
        clearForm();
    });

    document.querySelectorAll('.edit-article-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            idField.value = btn.dataset.id;
            headerField.value = btn.dataset.header;
            contentField.value = btn.dataset.content;
            tagField.value = btn.dataset.tag;

            formContainer.style.display = 'block';
            form.scrollIntoView({ behavior: 'smooth' });
        });
    });
</script>
