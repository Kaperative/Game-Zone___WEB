<?php
/**
 * @var App\Core\View\View $view
 * @var Session $session
 * @var int $countUsers
 * @var int $countSupportRequest
 * @var int $countArticles
 * @var int $countBrands
 */

use App\Core\Session\Session;
?>

<?php $view->includeComponent("header"); ?>
<?php $view->includeComponent("topLine"); ?>
<main class="admin-dashboard">
    <div class="admin-container">
        <h1 class="admin-title">Административная панель</h1>

        <div class="admin-cards">

            <div class="admin-card" onclick="window.location.href='/admin/support'">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <h3>Обращения поддержки</h3>
                <p>Управление запросами пользователей и ответами</p>
                <div class="card-badge">Необработанных вопросов: <?=$countSupportRequest?></div>
            </div>

            <!-- Карточка управления статьями -->
            <div class="admin-card" onclick="window.location.href='/admin/articles'">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <h3>Управление статьями</h3>
                <p>Создание и редактирование статей</p>
                <div class="card-badge">Всего: <?=$countArticles?></div>
            </div>

            <!-- Карточка управления пользователями -->
            <div class="admin-card" onclick="window.location.href='/admin/users'">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3>Управление пользователями</h3>
                <p>Редактирование прав и статусов</p>
                <div class="card-badge">Всего: <?=$countUsers ?></div>
            </div>


            <div class="admin-card" onclick="window.location.href='/admin/brands'">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3>Управление брэндами</h3>
                <p>Редактирование прав и статусов</p>
                <div class="card-badge">Всего: <?=$countBrands ?></div>
            </div>


            <div class="admin-card" onclick="window.location.href='/admin/sizes'">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3>Управление размерами</h3>
                <p>Редактирование прав и статусов</p>
                <div class="card-badge">Всего: <?=$countBrands ?></div>
            </div>

            <div class="admin-card" onclick="window.location.href='/admin/colors'">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3>Управление цветами</h3>
                <p>Редактирование прав и статусов</p>
                <div class="card-badge">Всего: <?=$countBrands ?></div>
            </div>

            <div class="admin-card" onclick="window.location.href='/admin/logs'">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3>Управление логами</h3>
                <p>Редактирование прав и статусов</p>
                <div class="card-badge">Всего: <?=$countBrands ?></div>
            </div>

            ///

            <div class="admin-card" onclick="window.location.href='/admin/logs'">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3>Управление логами</h3>
                <p>Редактирование прав и статусов</p>
                <div class="card-badge">Всего: <?=$countBrands ?></div>
            </div>

            <div class="admin-card" onclick="window.location.href='/admin/logs'">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3>Управление логами</h3>
                <p>Редактирование прав и статусов</p>
                <div class="card-badge">Всего: <?=$countBrands ?></div>
            </div>

            <div class="admin-card" onclick="window.location.href='/admin/logs'">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3>Управление логами</h3>
                <p>Редактирование прав и статусов</p>
                <div class="card-badge">Всего: <?=$countBrands ?></div>
            </div>

            <div class="admin-card" onclick="window.location.href='/admin/logs'">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3>Управление логами</h3>
                <p>Редактирование прав и статусов</p>
                <div class="card-badge">Всего: <?=$countBrands ?></div>
            </div>


        </div>


    </div>
</main>

<style>
    .admin-dashboard {
        background-color: #f8fafc;
        min-height: calc(100vh - 120px);
        padding: 2rem;
    }

    .admin-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .admin-title {
        font-size: 2rem;
        color: #2d3748;
        margin-bottom: 2rem;
        font-weight: 600;
    }

    .admin-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .admin-card {
        background: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: all 0.2s ease;
        border-left: 4px solid #4299e1;
        position: relative;
        overflow: hidden;
    }

    .admin-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .card-icon {
        width: 48px;
        height: 48px;
        background-color: #ebf8ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .card-icon svg {
        width: 24px;
        height: 24px;
        color: #4299e1;
    }

    .admin-card h3 {
        font-size: 1.25rem;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .admin-card p {
        color: #718096;
        margin-bottom: 1rem;
    }

    .card-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background-color: #4299e1;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
    }

    .quick-actions {
        background: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .quick-actions h2 {
        font-size: 1.25rem;
        color: #2d3748;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .action-btn {
        background-color: #4299e1;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: background-color 0.2s;
        font-size: 0.875rem;
    }

    .action-btn:hover {
        background-color: #3182ce;
    }

    @media (max-width: 768px) {
        .admin-cards {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-btn {
            width: 100%;
        }
    }
</style>
<?php $view->includeComponent("footer"); ?>
