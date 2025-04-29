
<?php include_once APP_PATH."/views/includes/header.php" ?>
<main class="register-page">
    <div class="register-container">
        <div class="register-box">
            <h1>Создать аккаунт</h1>
            <p>Присоединяйтесь к миллионам игроков по всему миру</p>
            
            <form id="register-form" class="auth-form" method="POST" action=<?=APP_PATH."/controller/reg.php"?>>
                <div class="form-group">
                    <label for="username">Имя пользователя</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email адрес</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" required>
                    <div class="password-strength">
                        <span class="strength-bar weak"></span>
                        <span class="strength-bar medium"></span>
                        <span class="strength-bar strong"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirm-password">Подтвердите пароль</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Продолжить</button>
            </form>
            
            <div class="social-login">
                <p>Или войти через:</p>
                <div class="social-buttons">
                    <button class="btn btn-social btn-steam"><i class="fab fa-steam"></i> Steam</button>
                    <button class="btn btn-social btn-epic"><i class="fas fa-gamepad"></i> Epic Games</button>
                    <button class="btn btn-social btn-google"><i class="fab fa-google"></i> Google</button>
                </div>
            </div>
            
            <div class="login-link">
                Уже есть аккаунт? <a href="login.html">Войти</a>
            </div>
        </div>
        
        <div class="register-benefits">
            <h2>Преимущества аккаунта GameStore</h2>
            <ul>
                <li><i class="fas fa-gamepad"></i> Доступ к тысячам игр</li>
                <li><i class="fas fa-users"></i> Присоединяйтесь к сообществу</li>
                <li><i class="fas fa-tag"></i> Специальные предложения и скидки</li>
                <li><i class="fas fa-cloud"></i> Облачные сохранения</li>
                <li><i class="fas fa-trophy"></i> Достижения и статистика</li>
            </ul>
        </div>
    </div>
</main>

<?php include_once APP_PATH."/views/includes/footer.php" ?>