<?php
/**
 * @var View $view
 * @var AuthService $auth
 */

use App\Core\Services\AuthService;
use App\Core\View\View;

?>

<div class="top-line">
</div>
<header class="main-header">
    <div class="header-container">
        <div class="logo">
            <a href="/home">
                <img src="/assets/img/logo/logo.png" alt="GameStore Logo">
            </a>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="store.html">Магазин</a></li>
                <li><a href="library.html">Библиотека</a></li>
                <li><a href="community.html">Сообщество</a></li>
                <li><a href="support.html">Поддержка</a></li>
            </ul>
        </nav>
        <?php
        if (!$auth->isLogin()) { ?>
            <div class="header-actions">
                <a href="/auth"><button class="btn btn-small btn-login">Войти</button></a>
            </div>

        <?php }
        else {?>
            <div class="header-actions">
                <a href="/files/index"><button class="btn btn-small btn-login">FileManager</button></a>
            </div>
            <a href="/logout"><button class="btn btn-small btn-login">Выйти</button></a>
        <?php } ?>
    </div>
</header>