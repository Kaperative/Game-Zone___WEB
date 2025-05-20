<?php

use App\services\AuthService;

/**
 * @var AuthService $auth;
 */
?>


        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar"></div>
                <h1 class="profile-login">
                    <?= $auth->getLogin() ?>
                    <span class="admin-badge"> <?php if($auth->isAdmin()){ echo 'Админ'; } else { echo "Пользователь";}?>
                </h1>
            </div>

            <div class="profile-details">
                <div class="detail-row">
                    <div class="detail-label">ID пользователя:</div>
                    <div class="detail-value"><?= $auth->getId()?></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Логин:</div>
                    <div class="detail-value"> <?= $auth->getLogin() ?></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Email:</div>
                    <div class="detail-value"><?= $auth->getEmail() ?></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Дата регистрации:</div>
                    <div class="detail-value"><?= $auth->getDataCreated()?></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Администратор:</div>
                    <div class="detail-value"> <?php if($auth->isAdmin()) {echo "Да";} else  {echo "Нет";} ?></div>
                </div>
            </div>
        </div>

