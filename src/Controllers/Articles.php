<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\DataBase\Model\Article;
use App\Core\DataBase\Model\User;

class Articles extends Controller
{
    public function index(): void
    {
        $this->view->page("/articles");
    }

    public function getArticles(): void
    {
        // Получаем данные из запроса
        $login = $this->request->post['login'] ?? null;

        if (empty($login)) {
            $this->session->set('error', 'Логин не указан');
            $this->redirect('/articles');
            return;
        }

        // Получаем ID пользователя
        $user = new User();
        $userId = $user->getID($login);

        if (empty($userId)) {
        $this->session->set('error', 'Пользователь не найден');
        $this->redirect('/articles');
        return;
    }

    // Получаем статьи пользователя
    $articleModel = new Article();
    $articles = $articleModel->getArticlesFromUserID($userId, 10);

    if (empty($articles)){
        $this->session->set('info', 'У пользователя нет статей');
        $this->redirect('/articles');
        return;
    }

    // Сохраняем статьи в сессии и перенаправляем
    $this->session->set('articles', $articles);
    $this->redirect('/articles');
}


}