<?php
/**
 * @var App\Core\View\View $view
 * @var Session $session
 * @var array $tickets
 * @var int $totalPages
 * @var int $currentPage
 */
use App\Core\Session\Session;
?>
<?php $view->includeComponent("header"); ?>
<?php $view->includeComponent("topLine"); ?>



       <?php $view->includeComponent('UserTable/supportTable'); ?>

        <!-- Кнопка создания -->
        <button class="create-ticket" onclick="window.location.href='/help/help'">
            + Создать тикет
        </button>

        <!-- Модальное окно с ответом -->
        <div id="ticketModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="modal-title"></h2>
                <div class="ticket-info">
                    <p><strong>Статус:</strong> <span id="modal-status"></span></p>
                    <p><strong>Дата создания:</strong> <span id="modal-created"></span></p>
                </div>

                <div class="message-container">
                    <h3>Ваше сообщение:</h3>
                    <div id="modal-message" class="user-message"></div>

                    <h3>Ответ поддержки:</h3>
                    <div id="modal-response" class="admin-response"></div>

                    <?php if ($session->has('response_rated')): ?>
                        <div class="alert alert-success">
                            <?= $session->getFlush('response_rated') ?>
                        </div>
                    <?php endif; ?>

                    <div id="rating-section" class="rating-section">
                        <p>Оцените ответ администратора:</p>
                        <div class="stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="star" data-rating="<?= $i ?>">★</span>
                            <?php endfor; ?>
                        </div>
                        <button id="submit-rating" class="submit-rating">Отправить оценку</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
        }

        .simple-support {
            padding: 2rem;
            max-width: 1200px;
            margin: auto;
        }

        .simple-title {
            font-size: 1.75rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .tickets-table-container {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .tickets-table {
            width: 100%;
            border-collapse: collapse;
        }

        .tickets-table th, .tickets-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .tickets-table th {
            font-weight: 600;
            color: #374151;
            background-color: #f3f4f6;
        }

        .tickets-table tr:hover {
            background-color: #f9fafb;
        }

        .ticket-row {
            cursor: pointer;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-badge.new {
            background-color: #dbeafe;
            color: #1d4ed8;
        }

        .status-badge.in_progress {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-badge.resolved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
            gap: 0.5rem;
        }

        .page-link {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }

        .page-link:hover {
            background-color: #e5e7eb;
        }

        .page-link.active {
            background-color: #3b82f6;
            color: white;
        }

        .create-ticket {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-size: 1rem;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .create-ticket:hover {
            background-color: #2563eb;
        }

        /* Модальное окно */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 2rem;
            border-radius: 0.75rem;
            max-width: 700px;
            width: 90%;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            position: relative;
        }

        .close {
            position: absolute;
            right: 1.5rem;
            top: 1.5rem;
            font-size: 1.75rem;
            cursor: pointer;
            color: #6b7280;
        }

        .close:hover {
            color: #111827;
        }

        .ticket-info {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .message-container {
            margin-top: 1rem;
        }

        .user-message, .admin-response {
            background-color: #f9fafb;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #3b82f6;
        }

        .admin-response {
            border-left-color: #10b981;
        }

        .rating-section {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .stars {
            font-size: 2rem;
            color: #e5e7eb;
            margin: 0.5rem 0;
        }

        .star {
            cursor: pointer;
            transition: color 0.2s;
        }

        .star:hover, .star.active {
            color: #f59e0b;
        }

        .submit-rating {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            cursor: pointer;
            margin-top: 0.5rem;
        }

        .submit-rating:hover {
            background-color: #2563eb;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        @media (max-width: 768px) {
            .tickets-table-container {
                overflow-x: auto;
            }

            .tickets-table {
                font-size: 0.875rem;
            }

            .tickets-table th, .tickets-table td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Открытие модального окна при клике на строку таблицы
            const ticketRows = document.querySelectorAll('.ticket-row');
            const modal = document.getElementById('ticketModal');
            const closeBtn = document.querySelector('.close');

            ticketRows.forEach(row => {
                row.addEventListener('click', function() {
                    const ticketId = this.getAttribute('data-ticket-id');

                    // Здесь должен быть AJAX-запрос для получения данных тикета
                    fetch(`/help/ticket/${ticketId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('modal-title').textContent = data.subject;
                            document.getElementById('modal-status').textContent = data.status_text;
                            document.getElementById('modal-status').className = 'status-badge ' + data.status;
                            document.getElementById('modal-created').textContent = data.created_at;
                            document.getElementById('modal-message').innerHTML = data.message;
                            document.getElementById('modal-response').innerHTML = data.response || 'Ответа пока нет';

                            // Показываем/скрываем секцию оценки
                            const ratingSection = document.getElementById('rating-section');
                            if (data.status === 'resolved' && !data.is_rated) {
                                ratingSection.style.display = 'block';
                            } else {
                                ratingSection.style.display = 'none';
                            }

                            modal.style.display = 'flex';
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });

            // Закрытие модального окна
            closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });

            // Логика оценки звездами
            const stars = document.querySelectorAll('.star');
            let selectedRating = 0;

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    selectedRating = rating;

                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });
            });

            // Отправка оценки
            document.getElementById('submit-rating').addEventListener('click', function() {
                if (selectedRating === 0) {
                    alert('Пожалуйста, выберите оценку');
                    return;
                }

                const ticketId = document.querySelector('.ticket-row[data-ticket-id]').getAttribute('data-ticket-id');

                fetch('/help/rate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        ticket_id: ticketId,
                        rating: selectedRating
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Перезагружаем страницу для обновления данных
                        } else {
                            alert('Ошибка: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>

<?php $view->includeComponent("footer"); ?>