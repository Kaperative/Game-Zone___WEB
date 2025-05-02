<?php
/**
 * @var App\Core\View\View $view
 * @var Session $session
 */

use App\Core\Session\Session;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form method="post" action="/articles">
    <input name="login"></input>
</form>
<?php if ($session->has('articles')): ?>
    <div class="articles-list">
        <?php foreach ($session->getFlush('articles') as $article): ?>
            <div class="article">
                <h3><?= htmlspecialchars($article['id_user']) ?></h3>
                <p><?= htmlspecialchars($article['content']) ?></p>
                <p><?= htmlspecialchars($article['likes']) ?></p>
                <p><?= htmlspecialchars($article['dislikes']) ?></p>
                <p><?= htmlspecialchars($article['created_at']) ?></p>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
</body>
</html>