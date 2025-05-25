<?php
use App\Core\View\View as ViewAlias;
use App\services\AuthService;

/**
 * @var ViewAlias $view
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
    }.modal {
         display: none;
         position: fixed;
         z-index: 1000;
         left: 0;
         top: 0;
         width: 100%;
         height: 100%;
         background-color: rgba(0, 0, 0, 0.5);
         overflow-y: auto;
     }

    .modal-content {
        background-color: #fff;
        margin: 50px auto;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        width: 80%;
        max-width: 800px;
        position: relative;
    }

    .close-modal {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 24px;
        color: #718096;
        cursor: pointer;
    }

    .close-modal:hover {
        color: #4a5568;
    }

    .modal-header {
        padding-bottom: 15px;
        margin-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
    }

    .modal-title {
        font-size: 20px;
        font-weight: 500;
        color: #2d3748;
        margin: 0;
    }

    .modal-body {
        margin-bottom: 20px;
    }

    .request-detail {
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f8fafc;
        border-radius: 6px;
    }

    .request-detail h4 {
        margin-top: 0;
        margin-bottom: 10px;
        font-size: 16px;
        color: #4a5568;
    }

    .request-detail p {
        margin: 0;
        color: #4a5568;
        line-height: 1.5;
    }

    .response-detail {
        padding: 15px;
        background-color: #ebf8ff;
        border-radius: 6px;
        border-left: 4px solid #4299e1;
    }

    .response-detail h4 {
        margin-top: 0;
        margin-bottom: 10px;
        font-size: 16px;
        color: #2b6cb0;
    }

    .response-detail p {
        margin: 0;
        color: #4a5568;
        line-height: 1.5;
    }

    .no-response {
        color: #a0aec0;
        font-style: italic;
    }

    /* Делаем строки таблицы кликабельными */
    .table tbody tr {
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
    }
</style>

<div class="admin-dashboard">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Список обращений</h2>
        </div>


        <div id="reply-form-container" class="form-container">

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
                </tr>
                </thead>
                <tbody>
                <?php foreach ($supportRequests as $request): ?>
                    <tr data-request-id="<?= $request['id'] ?>"
                        data-header="<?= htmlspecialchars($request['header_request']) ?>"
                        data-content="<?= htmlspecialchars($request['body_request'] ?? '') ?>"
                        data-response="<?= htmlspecialchars($request['header_answer'] ?? '') ?>"
                        data-response-content="<?= htmlspecialchars($request['body_answer'] ?? '') ?>"
                        data-processed="<?= $request['processed'] ? '1' : '0' ?>">
                        <td><?= $request['id'] ?></td>
                        <td><?= $request['id_user'] ?></td>
                        <td><?= htmlspecialchars($request['header_request']) ?></td>
                        <td><?= date('d.m.Y H:i', $request['created_at']) ?></td>
                        <td>
                            <span class="badge <?= $request['processed'] ? 'badge-success' : 'badge-warning' ?>">
                                <?= $request['processed'] ? 'Обработано' : 'В ожидании' ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php $view->includeComponent('/Pagination/defaultPagination'); ?>

    <div id="requestModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-header">
                <h3 class="modal-title" id="modalRequestTitle"></h3>
            </div>
            <div class="modal-body">
                <div class="request-detail">
                    <h4>Обращение пользователя:</h4>
                    <p id="modalRequestContent"></p>
                </div>
                <div class="response-detail">
                    <h4>Ответ администрации:</h4>
                    <p id="modalResponseContent" class="<?= empty($request['body_answer']) ? 'no-response' : '' ?>">
                        <?= !empty($request['body_answer']) ? htmlspecialchars($request['body_answer']) : 'Ответа пока нет' ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Получаем элементы модального окна
        const modal = document.getElementById('requestModal');
        const closeModal = document.querySelector('.close-modal');
        const modalTitle = document.getElementById('modalRequestTitle');
        const modalRequestContent = document.getElementById('modalRequestContent');
        const modalResponseContent = document.getElementById('modalResponseContent');

        // Делаем строки таблицы кликабельными
        const tableRows = document.querySelectorAll('.table tbody tr');

        tableRows.forEach(row => {
            row.addEventListener('click', function() {
                // Получаем данные из атрибутов строки
                const requestId = this.getAttribute('data-request-id');
                const header = this.getAttribute('data-header');
                const content = this.getAttribute('data-content');
                const response = this.getAttribute('data-response');
                const responseContent = this.getAttribute('data-response-content');
                const processed = this.getAttribute('data-processed');

                // Заполняем модальное окно данными
                modalTitle.textContent = header;
                modalRequestContent.textContent = content || 'Нет содержимого';

                if (responseContent) {
                    modalResponseContent.textContent = responseContent;
                    modalResponseContent.className = '';
                } else {
                    modalResponseContent.textContent = 'Ответа пока нет';
                    modalResponseContent.className = 'no-response';
                }

                // Показываем модальное окно
                modal.style.display = 'block';
            });
        });

        // Закрытие модального окна
        closeModal.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Закрытие при клике вне модального окна
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>
