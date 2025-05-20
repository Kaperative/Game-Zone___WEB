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

<main class="posts">

    <div class="post">
        <p>Это пример содержимого поста (content). Очень интересный пост с полезной информацией!</p>
        <div class="meta">
            <span>👍 15</span>
            <span>👎 3</span>
        </div>
        <div class="dates">
            <small>Создано: 2025-05-06</small>
            <small>Обновлено: 2025-05-06</small>
        </div>
    </div>

    <div class="post">
        <p>Второй пример поста — здесь немного другой текст и меньше лайков.</p>
        <div class="meta">
            <span>👍 7</span>
            <span>👎 1</span>
        </div>
        <div class="dates">
            <small>Создано: 2025-04-30</small>
            <small>Обновлено: 2025-05-01</small>
        </div>
    </div>

</main>

<?php $view->includeComponent("footer"); ?>