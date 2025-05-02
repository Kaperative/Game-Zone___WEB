<?php
/**
 * @var App\Core\View\View $view
 * @var Session $session
 */

use App\Core\Session\Session;
?>

<?php $view->includeComponent("header"); ?>

    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo">
                <img src="/assets/images/logo.svg" alt="GameHub">
            </div>

            <div class="auth-content">
                <h1 class="auth-title">Добро пожаловать</h1>
                <p class="auth-subtitle">Войдите в свой аккаунт</p>


                <form class="auth-form" method="POST" action="/auth">
                    <div class="form-group">
                        <label for="login" class="form-label">Логин или Email</label>
                        <div class="input-group">
                            <span class="input-icon"><i class="fas fa-user"></i></span>
                            <input type="text" id="login" name="login" class="form-control" placeholder="Ваш логин" required>
                        </div>
                        <?php if ($session->has('login_error')): ?>
                            <div class="invalid-feedback">
                                <li style="color: #d94126"> <?= htmlspecialchars($session->getFlush('login_error')) ?> </li>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Пароль</label>
                        <div class="input-group">
                            <span class="input-icon"><i class="fas fa-lock"></i></span>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Ваш пароль" required>
                            <button type="button" class="password-toggle" aria-label="Показать пароль">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?php if ($session->has('password_error')): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($session->getFlush('password_error')[0]) ?>
                            </div>
                        <?php endif; ?>
                        <div class="text-right">
                            <a href="/forgot-password" class="forgot-link">Забыли пароль?</a>
                        </div>
                    </div>

                    <div class="form-group flex-group">
                        <div class="form-check">
                            <input type="checkbox" id="remember" name="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">Запомнить меня</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-auth">Войти</button>
                </form>

                <div class="auth-divider">
                    <span>или</span>
                </div>

                <div class="social-auth">
                    <button class="btn btn-social btn-steam">
                        <i class="fab fa-steam"></i> Steam
                    </button>
                    <button class="btn btn-social btn-google">
                        <i class="fab fa-google"></i> Google
                    </button>
                </div>

                <div class="auth-footer">
                    Ещё нет аккаунта? <a href="/register" class="auth-link">Создать</a>
                </div>
            </div>
        </div>
    </div>

<?php include_once APP_PATH."/views/components/footer.php" ?>