<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Models\Article;
use App\Models\SupportRequest;
use App\Models\User;
use App\services\AuthService;
use JetBrains\PhpStorm\NoReturn;

class AdminController extends Controller
{

    public function indexAdmins(): void
    {
        $page = (int)($this->request->inputGET('page') ?? 1);
        $perPage = (int)($this->request->inputGET('per_page') ?? 10);
        $search = $this->request->inputGET('search') ?? '';

        $userModel = new User();

        $result = $userModel->getPaginatedUsers($page, $perPage, $search);


        $this->view->render('/admin/admins', [
            'users' => $result['users'],
            'currentPage' => $page,
            'totalPages' => $result['total_pages'],
            'perPage' => $perPage,
            'searchQuery' => $search
        ]);

    }

    public function indexSupport(): void
    {
        $page = (int)($this->request->inputGET('page') ?? 1);
        $perPage = (int)($this->request->inputGET('per_page') ?? 10);
        $search = $this->request->inputGET('search') ?? '';

        $supportModel = new SupportRequest();
        $result =$supportModel->getPaginationSupportRequest($page, $perPage, $search);


        $this->view->render('/admin/supportRequests', [
            'supportRequests' => $result['supportRequests'],
            'currentPage' => $page,
            'totalPages' => $result['total_pages'],
            'perPage' => $perPage,
            'searchQuery' => $search
        ]);

    }

    public function deleteSupport():void
    {
        //dd($_SERVER);
        $id=$this->request->inputGET('id');
        $support = new SupportRequest();
        $support->deleteRequest($id);
        $this->redirect('/admin/support');
    }

    public function indexArticles(): void
    {
        $page = (int)($this->request->inputGET('page') ?? 1);
        $perPage = (int)($this->request->inputGET('per_page') ?? 10);
        $search = $this->request->inputGET('search') ?? '';

        $articleModel = new Article();

        $result =$articleModel->getPaginatedArticles($page, $perPage, $search);


        $this->view->render('/admin/articles', [
            'articles' => $result['articles'],
            'currentPage' => $page,
            'totalPages' => $result['total_pages'],
            'perPage' => $perPage,
            'searchQuery' => $search
        ]);
    }
    #[NoReturn] public function deleteArticle(): void
    {
        $id=$this->request->inputGET('article_id');
        $article = new Article();
        $article->deleteArticle($id);
        $this->redirect('/admin/articles');
    }

    #[NoReturn] public function deleteUser(): void
    {
        $id=$this->request->inputGET('user_id');
        $userModel = new User();
        $userModel->deleteUser($id);
        $this->redirect('/admin/admins');
    }

    #[NoReturn] public function setAdmin(): void
    {
        $id=$this->request->inputGET('user_id');
//dd($id);
        $userModel = new User();
        $userModel->setAdmin($id);
        $this->redirect('/admin/admins');
    }

    #[NoReturn] public function unsetAdmin(): void
    {

        $id=$this->request->inputGET('user_id');
        $auth = new AuthService();
        $id_this = $auth->getId();
        if ($id_this!=$id)
        {
            $userModel = new User();
            $userModel->unsetAdmin($id);

        }
        $this->redirect('/admin/admins');
    }

    #[NoReturn] public function addArticle(): void
    {

        $user_id = $this->request->inputPOST('id');
        $header = $this->request->inputPOST('header');
        $content = $this->request->inputPOST('content');
        $tags = $this->request->inputPOST('tags');
        $article = new Article();
        $article->create($user_id, $header, $content, $tags);
        $this->redirect('/admin/articles');
    }

}