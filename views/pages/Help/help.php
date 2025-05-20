<?php
/**
 * @var App\Core\View\View $view
 * @var Session $session
 * @var User $user;
 */

use App\Core\Session\Session;
use App\Models\User;
?>

<?php $view->includeComponent("header"); ?>
<?php $view->includeComponent("topLine"); ?>

    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #eef2ff;
            --success: #10b981;
            --danger: #ef4444;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-500: #6b7280;
            --gray-700: #374151;
        }

        .contact-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .contact-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .contact-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .contact-subtitle {
            color: var(--gray-500);
            font-size: 1rem;
        }

        .contact-form {
            display: grid;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--gray-700);
            font-size: 0.9rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        .file-input {
            display: none;
        }

        .file-upload {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .file-label {
            padding: 0.75rem 1.5rem;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .file-label:hover {
            background: #e0e7ff;
        }

        .file-label svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }

        .file-name {
            font-size: 0.9rem;
            color: var(--gray-500);
        }

        .btn-submit {
            padding: 0.75rem 1.5rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
        }

        .btn-submit:hover {
            background: #3a56d4;
            transform: translateY(-2px);
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-success {
            background: #ecfdf5;
            color: var(--success);
            border: 1px solid #a7f3d0;
        }

        .alert-danger {
            background: #fef2f2;
            color: var(--danger);
            border: 1px solid #fecaca;
        }

        @media (max-width: 768px) {
            .contact-container {
                margin: 1rem;
                padding: 1.5rem;
                border-radius: 12px;
            }

            .contact-title {
                font-size: 1.5rem;
            }
        }
    </style>

    <main class="contact-container">
        <div class="contact-header">
            <h1 class="contact-title">Свяжитесь с нами</h1>
            <p class="contact-subtitle">Мы ответим вам в течение 24 часов</p>
        </div>

        <?php if ($session->has('success')): ?>
            <div class="alert alert-success">
                <?= $session->getFlush('success') ?>
            </div>
        <?php endif; ?>

        <?php if ($session->has('error')): ?>
            <div class="alert alert-danger">
                <?= $session->getFlush('error') ?>
            </div>
        <?php endif; ?>

        <form class="contact-form" action="/help/mail" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="subject" class="form-label">Тема сообщения</label>
                <input type="text" id="subject" name="subject" class="form-control"
                       placeholder="Например: Ошибка в работе сайта" required>
            </div>

            <div class="form-group">
                <label for="message" class="form-label">Ваше сообщение</label>
                <textarea id="message" name="message" class="form-control"
                          placeholder="Опишите подробно вашу проблему или вопрос..." required></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Прикрепить файлы</label>
                <div class="file-upload">
                    <label for="attachments" class="file-label">
                        <svg viewBox="0 0 24 24">
                            <path d="M18 15v3H6v-3H4v3c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-3h-2zM7 9l1.41 1.41L11 7.83V16h2V7.83l2.59 2.58L17 9l-5-5-5 5z"/>
                        </svg>
                        Выбрать файлы
                    </label>
                    <span class="file-name" id="file-names">Файлы не выбраны</span>
                    <input type="file" id="attachments" name="files[]" class="file-input" multiple
                           accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" onchange="updateFileNames()">
                </div>
                <small style="color: var(--gray-500);">Максимум 3 файла по 3 МБ каждый</small>
            </div>

            <button type="submit" class="btn-submit">
                Отправить сообщение
            </button>
        </form>
    </main>

    <script>
        function updateFileNames() {
            const input = document.getElementById('attachments');
            const label = document.getElementById('file-names');

            if (input.files.length > 0) {
                const names = Array.from(input.files).map(file => file.name);
                label.textContent = names.join(', ');
            } else {
                label.textContent = 'Файлы не выбраны';
            }
        }
    </script>

<?php $view->includeComponent("footer"); ?>