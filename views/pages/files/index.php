<?php
/**
 * @var View $view
 */

use App\Core\View\View;
?>

<?php $view->includeComponent('header'); ?>
<div class="file-manager">
    <h1>Файловый менеджер</h1>

    <?php if (!empty($message)): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="upload-form">
        <h2>Загрузить файл</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="file" required>
            <button type="submit">Загрузить</button>
        </form>
    </div>

    <div class="file-list">
        <h2>Список файлов</h2>
        <?php if (empty($files)): ?>
            <p>Нет загруженных файлов</p>
        <?php else: ?>
            <?php foreach ($files as $file): ?>
                <div class="file-item">
                    <span><?= htmlspecialchars($file) ?></span>
                    <div>
                        <a href="/files/download?nameFile=<?= urlencode($file) ?>">Скачать</a>
                        <a href="/files/index?delete=<?= urlencode($file) ?>"
                           onclick="return confirm('Удалить файл <?= htmlspecialchars($file) ?>?')">
                            Удалить
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
</body>
</html>