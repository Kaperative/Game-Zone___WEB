<!DOCTYPE html>
<html>
<head>
    <title>Файловый менеджер</title>
    <style>
        .file-manager {
            max-width: 800px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
        }
        .file-list {
            margin: 20px 0;
            border: 1px solid #ddd;
            padding: 10px;
        }
        .file-item {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .file-item:last-child {
            border-bottom: none;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            background: #f0f0f0;
        }
        .upload-form {
            margin: 20px 0;
            padding: 20px;
            background: #f9f9f9;
            border: 1px dashed #ccc;
        }
    </style>
</head>
<body>
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