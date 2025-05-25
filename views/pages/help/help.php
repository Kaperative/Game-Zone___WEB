<?php /**
 * @var App\Core\View\View $view
 * @var Session $session
 * @var User $user;
 */
use App\Core\Session\Session;
use App\Models\User; ?>

<?php $view->includeComponent("header"); ?>
<?php $view->includeComponent("topLine"); ?>

<style>
    :root {
        --primary: #4CAF50;
        --primary-light: #A5D6A7;
        --secondary: #FF5722;
        --gray-100: #f5f5f5;
        --gray-200: #e0e0e0;
        --gray-300: #bdbdbd;
        --gray-500: #616161;
        --gray-700: #424242;
    }

    body {
        background-color: var(--gray-100);
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .contact-container {
        max-width: 900px;
        margin: 3rem auto;
        padding: 3rem;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .contact-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .contact-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    .contact-subtitle {
        color: var(--gray-500);
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .contact-form {
        display: flex;
        flex-direction: column;
        gap: 1.8rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .form-label {
        font-weight: 500;
        color: var(--gray-700);
        font-size: 1rem;
    }

    .form-control {
        padding: 1rem;
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 5px var(--primary-light);
    }

    textarea.form-control {
        min-height: 180px;
        resize: vertical;
    }

    .file-upload {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .file-label {
        padding: 0.9rem 1.7rem;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .file-label:hover {
        background: var(--primary);
        color: white;
    }

    .file-label svg {
        width: 20px;
        height: 20px;
        fill: currentColor;
    }

    .file-name {
        font-size: 1rem;
        color: var(--gray-500);
    }

    .btn-submit {
        padding: 1rem 2rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-submit:hover {
        background: #388E3C;
        transform: translateY(-2px);
    }

    .alert {
        padding: 1.2rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        font-weight: 500;
        font-size: 1rem;
    }

    .alert-success {
        background: #E8F5E9;
        color: #388E3C;
        border: 1px solid #C8E6C9;
    }

    .alert-danger {
        background: #FFEBEE;
        color: #D32F2F;
        border: 1px solid #FFCDD2;
    }

    @media (max-width: 768px) {
        .contact-container {
            margin: 1rem;
            padding: 2rem;
            border-radius: 10px;
        }

        .contact-title {
            font-size: 2rem;
        }

        .contact-subtitle {
            font-size: 1rem;
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
            <input type="text" id="subject" name="subject" class="form-control" placeholder="Например: Ошибка в работе сайта" required>
        </div>

        <div class="form-group">
            <label for="message" class="form-label">Ваше сообщение</label>
            <textarea id="message" name="message" class="form-control" placeholder="Опишите подробно вашу проблему или вопрос..." required></textarea>
        </div>

        <button type="submit" class="btn-submit">Отправить сообщение</button>
    </form>
</main>

<?php $view->includeComponent("footer"); ?>
