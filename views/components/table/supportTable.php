<?php
use App\Models\User;
use App\services\AuthService;

/**
 * @var AuthService $auth
 * @var array $supportRequests
 * @var int $currentPage
 * @var int $totalPages
 * @var int $perPage
 * @var string $searchQuery
 */
?>

<style>
    .admin-dashboard {
        max-width: 1400px;
        margin: 20px auto;
        padding: 20px;
        font-family: 'Roboto', sans-serif;
        background-color: #f5f7fa;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e0e6ed;
    }

    .dashboard-title {
        font-size: 24px;
        color: #2c3e50;
        font-weight: 500;
    }

    .search-box {
        position: relative;
        width: 300px;
    }

    .search-input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border: 1px solid #dfe3e9;
        border-radius: 6px;
        font-size: 14px;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23a0aec0' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: 15px center;
    }

    .card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .card-header {
        padding: 15px 20px;
        background-color: #f8fafc;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        font-size: 16px;
        font-weight: 500;
        color: #4a5568;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
    }

    .btn-primary {
        background-color: #4299e1;
        color: white;
    }

    .btn-primary:hover {
        background-color: #3182ce;
    }

    .btn-danger {
        background-color: #f56565;
        color: white;
    }

    .btn-danger:hover {
        background-color: #e53e3e;
    }

    .btn-success {
        background-color: #48bb78;
        color: white;
    }

    .btn-success:hover {
        background-color: #38a169;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        padding: 12px 15px;
        text-align: left;
        background-color: #f8fafc;
        color: #718096;
        font-weight: 500;
        font-size: 14px;
        border-bottom: 1px solid #e2e8f0;
    }

    .table td {
        padding: 12px 15px;
        border-bottom: 1px solid #edf2f7;
        color: #4a5568;
        font-size: 14px;
    }

    .table tr:hover td {
        background-color: #f8fafc;
    }

    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-success {
        background-color: #c6f6d5;
        color: #22543d;
    }

    .badge-warning {
        background-color: #feebc8;
        color: #744210;
    }

    .badge-danger {
        background-color: #fed7d7;
        color: #742a2a;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .page-item {
        margin: 0 5px;
    }

    .page-link {
        display: block;
        padding: 8px 12px;
        border-radius: 6px;
        color: #4a5568;
        text-decoration: none;
        font-size: 14px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }

    .page-link:hover {
        background-color: #edf2f7;
    }

    .page-item.active .page-link {
        background-color: #4299e1;
        color: white;
        border-color: #4299e1;
    }

    .action-form {
        display: inline-block;
        margin-right: 5px;
    }

    .form-container {
        display: none;
        padding: 20px;
        background-color: #f8fafc;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .form-container.active {
        display: block;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 14px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
    }

    .text-danger {
        color: #e53e3e;
    }
</style>

<div class="admin-dashboard">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Управление обращениями</h1>
        <div class="search-box">
            <form method="get">
                <input type="text" name="search" class="search-input" placeholder="Поиск..."
                       value="<?= htmlspecialchars($searchQuery ?? '') ?>">
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Список обращений</h2>
            <button id="toggle-form-btn" class="btn btn-primary">Добавить статью</button>
        </div>

        <div id="article-form-container" class="form-container">
            <form id="article-form" method="post" action="/admin/save-article">
                <input type="hidden" name="id" id="article-id">
                <div class="form-group">
                    <input type="text" name="header" id="article-header" class="form-control" placeholder="Заголовок">
                </div>
                <div class="form-group">
                    <textarea name="content" id="article-content" class="form-control" placeholder="Содержимое" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <input type="text" name="tag" id="article-tag" class="form-control" placeholder="Тег">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Сохранить</button>
                    <button type="button" id="cancel-article-btn" class="btn btn-danger">Отмена</button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>ID пользователя</th>
                    <th>Заголовок</th>
                    <th>Дата создания</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($supportRequests as $request): ?>
                    <tr>
                        <td><?= $request['id'] ?></td>
                        <td><?= $request['id_user'] ?></td>
                        <td><?= htmlspecialchars($request['header_request']) ?></td>
                        <td><?= date('d.m.Y H:i', $request['created_at']) ?></td>
                        <td>
                                <span class="badge <?= $request['processed'] ? 'badge-success' : 'badge-warning' ?>">
                                    <?= $request['processed'] ? 'Обработано' : 'В ожидании' ?>
                                </span>
                        </td>
                        <td>
                            <form class="action-form" method="post" action="/admin/delete-support?id=<?= $request['id']?>"
                                  onsubmit="return confirm('Вы уверены, что хотите удалить это обращение?')">
                                <input type="hidden" name="id" value="<?= $request['id'] ?>">
                                <button type="submit" class="btn btn-danger">Удалить</button>
                            </form>
                            <form class="action-form" method="post" action="/admin/reply-support">
                                <input type="hidden" name="id" value="<?= $request['id'] ?>">
                                <button type="submit" class="btn btn-primary">Ответить</button>
                            </form>
                            <form class="action-form" method="post" action="/admin/process-support">
                                <input type="hidden" name="id" value="<?= $request['id'] ?>">
                                <button type="submit" class="btn btn-success">
                                    <?= $request['processed'] ? 'Отменить' : 'Обработать' ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <div class="page-item">
                <a href="?page=1&per_page=<?= $perPage ?>&search=<?= urlencode($searchQuery) ?>" class="page-link">Первая</a>
            </div>
            <div class="page-item">
                <a href="?page=<?= $currentPage - 1 ?>&per_page=<?= $perPage ?>&search=<?= urlencode($searchQuery) ?>" class="page-link">Назад</a>
            </div>
        <?php endif; ?>

        <?php for ($i = max(1, $currentPage - 2); $i <= min($currentPage + 2, $totalPages); $i++): ?>
            <div class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                <a href="?page=<?= $i ?>&per_page=<?= $perPage ?>&search=<?= urlencode($searchQuery) ?>" class="page-link"><?= $i ?></a>
            </div>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <div class="page-item">
                <a href="?page=<?= $currentPage + 1 ?>&per_page=<?= $perPage ?>&search=<?= urlencode($searchQuery) ?>" class="page-link">Вперед</a>
            </div>
            <div class="page-item">
                <a href="?page=<?= $totalPages ?>&per_page=<?= $perPage ?>&search=<?= urlencode($searchQuery) ?>" class="page-link">Последняя</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggle-form-btn');
        const cancelBtn = document.getElementById('cancel-article-btn');
        const formContainer = document.getElementById('article-form-container');
        const form = document.getElementById('article-form');
        const idField = document.getElementById('article-id');
        const headerField = document.getElementById('article-header');
        const contentField = document.getElementById('article-content');
        const tagField = document.getElementById('article-tag');

        function clearForm() {
            idField.value = '';
            headerField.value = '';
            contentField.value = '';
            tagField.value = '';
        }

        toggleBtn.addEventListener('click', function() {
            formContainer.classList.toggle('active');
            if (formContainer.classList.contains('active')) {
                clearForm();
                form.scrollIntoView({ behavior: 'smooth' });
            }
        });

        cancelBtn.addEventListener('click', function() {
            formContainer.classList.remove('active');
            clearForm();
        });

        // Обработка редактирования (если есть кнопки редактирования на странице)
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                idField.value = this.dataset.id;
                headerField.value = this.dataset.header;
                contentField.value = this.dataset.content;
                tagField.value = this.dataset.tag;
                formContainer.classList.add('active');
                form.scrollIntoView({ behavior: 'smooth' });
            });
        });
    });
</script>