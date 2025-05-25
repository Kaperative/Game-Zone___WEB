<?php
/**
 * @var View $view
 * @var AuthService $auth
 * @var bool $isAdmin
 * @var bool $isAuthorize
 */

use App\Core\View\View;
use App\services\AuthService;

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
                <li><a href="/shop  ">Магазин</a></li>
                <li><a href="library.html">Библиотека</a></li>
                <li><a href="community.html">Сообщество</a></li>
                <li><a href="/help/main">Поддержка</a></li>
            </ul>
        </nav>

        <?php if ($isAdmin) { ?>
            <div class="header-actions">
                <a href="/admin/main"><button class="btn btn-small btn-login">Admin Panel</button></a>
            </div>
        <?php }?>

        <?php
        if (!$isAuthorize) { ?>
            <div class="header-actions">
                <a href="/auth"><button class="btn btn-small btn-login">Войти</button></a>
            </div>


            <?php
        }
        else {?>

            <a href="/logout"><button class="btn btn-small btn-login">Выйти</button></a>
        <?php } ?>


    </div>
</header>