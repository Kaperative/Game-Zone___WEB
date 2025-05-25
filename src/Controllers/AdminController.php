<?php

namespace App\Controllers;

use App\Core\Config\Config;
use App\Core\Controller\Controller;
use App\Core\DataBase\DataBase;
use App\Models\AdminLog;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Categories;
use App\Models\Color;
use App\Models\Size;
use App\Models\SupportRequest;
use App\Models\User;
use App\services\AuthService;
use Exception;
use JetBrains\PhpStorm\NoReturn;


trait AdminLoggingTrait
{
    protected function logAction(string $action, string $entityType, ?int $entityId = null, ?string $details = null): void
    {
        $auth = new AuthService();
        $adminId = $auth->getId();

        if ($adminId) {
            $logModel = new AdminLog();
            $logModel->logAction($adminId, $action, $entityType, $entityId, $details);
        }
    }
}
class AdminController extends Controller
{
    use AdminLoggingTrait;

    public function index(): void
    {
        $user= new User();
        $supportRequest = new SupportRequest();
        $article = new Article();
        $brand = new Brand();

        $this->view->render('/admin/main',[
            'countUsers'=>$user->getCountUser(),
            'countSupportRequest'=>$supportRequest->getCountUnprocessedRequest(),
            'countArticles'=>$article->getCountArticles(),
            'countBrands'=>$brand->getCountBrands(),
        ]);
    }

    public function indexSizes():void
    {
        $page = (int)($this->request->inputGET('page') ?? 1);
        $perPage = (int)($this->request->inputGET('per_page') ?? 10);
        $search = $this->request->inputGET('search') ?? '';

        $model = new Size();

        $result = $model->getPaginatedSize($page, $perPage, $search);
        $columns =  $result['data'] ? array_keys( $result['data'][0]) : [];

        $this->view->render('/admin/sizes', [

            'tableName'=> 'sizes',
            'columns' => $columns,
            'rows' => $result['data'],
            'primary' => (new DataBase(new Config()))->getImmutableColumns('sizes'),
            'currentPage' => $page,
            'totalPages' => $result['total_pages'],
            'perPage' => $perPage,
            'searchQuery' => $search
        ]);
    }

    public function indexColor():void
    {
        $page = (int)($this->request->inputGET('page') ?? 1);
        $perPage = (int)($this->request->inputGET('per_page') ?? 10);
        $search = $this->request->inputGET('search') ?? '';

        $model = new Color();

        $result = $model->getPaginatedColor($page, $perPage, $search);
        $columns =  $result['data'] ? array_keys( $result['data'][0]) : [];

        $this->view->render('/admin/colors', [

            'tableName'=> 'colors',
            'columns' => $columns,
            'rows' => $result['data'],
            'primary' => (new DataBase(new Config()))->getImmutableColumns('colors'),
            'currentPage' => $page,
            'totalPages' => $result['total_pages'],
            'perPage' => $perPage,
            'searchQuery' => $search
        ]);
    }

    public function indexCategories():void
    {
        $page = (int)($this->request->inputGET('page') ?? 1);
        $perPage = (int)($this->request->inputGET('per_page') ?? 10);
        $search = $this->request->inputGET('search') ?? '';

        $model = new Categories();

        $result = $model->getPaginatedCategorie($page, $perPage, $search);
        $columns =  $result['data'] ? array_keys( $result['data'][0]) : [];

        $this->view->render('/admin/categories', [

            'tableName'=> 'categories',
            'columns' => $columns,
            'rows' => $result['data'],
            'primary' => (new DataBase(new Config()))->getImmutableColumns('categories'),
            'currentPage' => $page,
            'totalPages' => $result['total_pages'],
            'perPage' => $perPage,
            'searchQuery' => $search
        ]);
    }

    public function indexLogs():void
    {
        $page = (int)($this->request->inputGET('page') ?? 1);
        $perPage = (int)($this->request->inputGET('per_page') ?? 10);
        $search = $this->request->inputGET('search') ?? '';

        $model = new AdminLog();

        $result = $model->getPaginatedLogs($page, $perPage, $search);
        $columns =  $result['data'] ? array_keys( $result['data'][0]) : [];

        $this->view->render('/admin/categories', [

            'tableName'=> 'admin_logs',
            'columns' => $columns,
            'rows' => $result['data'],
            'primary' => (new DataBase(new Config()))->getImmutableColumns('categories'),
            'currentPage' => $page,
            'totalPages' => $result['total_pages'],
            'perPage' => $perPage,
            'searchQuery' => $search
        ]);
    }
    public function indexAdmins(): void
    {
        $page = (int)($this->request->inputGET('page') ?? 1);
        $perPage = (int)($this->request->inputGET('per_page') ?? 10);
        $search = $this->request->inputGET('search') ?? '';

        $userModel = new User();

        $result = $userModel->getPaginatedUsers($page, $perPage, $search);
        $columns =  $result['data'] ? array_keys( $result['data'][0]) : [];

        $this->view->render('/admin/admins', [

            'tableName'=> 'users',
            'columns' => $columns,
            'rows' => $result['data'],
            'primary' => (new DataBase(new Config()))->getImmutableColumns('users'),
            'currentPage' => $page,
            'totalPages' => $result['total_pages'],
            'perPage' => $perPage,
            'searchQuery' => $search
        ]);

    }


    public function indexArticles(): void
    {
        $page = (int)($this->request->inputGET('page') ?? 1);
        $perPage = (int)($this->request->inputGET('per_page') ?? 10);
        $search = $this->request->inputGET('search') ?? '';

        $articleModel = new Article();

        $result =$articleModel->getPaginatedArticles($page, $perPage, $search);


        $columns =  $result['data'] ? array_keys( $result['data'][0]) : [];

        $this->view->render('/admin/articles', [

            'tableName'=> 'articles',
            'columns' => $columns,
            'rows' => $result['data'],

            'currentPage' => $page,
            'totalPages' => $result['total_pages'],
            'perPage' => $perPage,
            'searchQuery' => $search
        ]);
    }

    public function indexBrands(): void
    {
        $page = (int)($this->request->inputGET('page') ?? 1);
        $perPage = (int)($this->request->inputGET('per_page') ?? 10);
        $search = $this->request->inputGET('search') ?? '';

        $articleModel = new Brand();

        $result =$articleModel->getPaginatedBrands($page, $perPage, $search);


        $columns =  $result['data'] ? array_keys( $result['data'][0]) : [];

        $this->view->render('/admin/brands', [

            'tableName'=> 'brands',
            'columns' => $columns,
            'rows' => $result['data'],
            'primary' => (new DataBase(new Config()))->getImmutableColumns('brands'),
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

        $columns =  $result['data'] ? array_keys( $result['data'][0]) : [];


        $this->view->render('/admin/supportRequests', [

            'tableName'=> 'support_request',
            'columns' => $columns,
            'rows' => $result['data'],
            'primary' => (new DataBase(new Config()))->getImmutableColumns('support_request'),
            'currentPage' => $page,
            'totalPages' => $result['total_pages'],
            'perPage' => $perPage,
            'searchQuery' => $search
        ]);
    }


    /**
     * @throws Exception
     */
    public function add(): void
    {
        $table = $_GET['table'] ?? null;
        $id = $_POST['record_id'] ?? null;

        if (!$table || !isset($_POST['fields'])) {
            throw new Exception("Missing table or fields data");
        }

        $fields = $_POST['fields'];

        $model = new DataBase(new Config());

// Получить список primary key колонок
        $primaryKeys = $model->getImmutableColumns( $table);
//dd($primaryKeys);
// Убрать из $fields все поля, которые являются PK (например, 'id')
        foreach ($primaryKeys as $pk) {
            if (empty($id)) { // если добавление, убираем PK
                unset($fields[$pk]);
            }
        }

        if ($id) {
            // UPDATE
            $placeholders = implode(', ', array_map(fn($k) => "`$k` = ?", array_keys($fields)));
            $values = array_values($fields);
            $values[] = $id;

            $sql = "UPDATE `$table` SET $placeholders WHERE id = ?";
            $this->logAction('update', 'users', $id, 'User updated successfully');
        } else {
            // INSERT
            $columns = implode(', ', array_keys($fields));
            $binds = implode(', ', array_fill(0, count($fields), '?'));
            $values = array_values($fields);

            $sql = "INSERT INTO `$table` ($columns) VALUES ($binds)";
            $this->logAction('create', $table, $id, 'User created successfully');
        }

        $stmt = $model->pdo->prepare($sql);
        $stmt->execute($values);

        $this->redirect($this->request->server['HTTP_REFERER']);

    }


    #[NoReturn] public function delete():void
    {
        $table = $this->request->inputGET('table');
        $id = $this->request->inputGET('id');
        $this->logAction('delete', $table, $id, 'User deleted successfully');
        $model = (new DataBase(new Config()))->deleteById($table, $id);
        $this->redirect($this->request->server['HTTP_REFERER']);
    }


    #[NoReturn] public function setAdmin(): void
    {
        $id=$this->request->inputGET('user_id');
//dd($id);
        $userModel = new User();
        $this->logAction('set_admin', 'users', $id, 'User promoted to admin');
        $userModel->setAdmin($id);
        $this->redirect($this->request->server['HTTP_REFERER']);
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

        $this->redirect($this->request->server['HTTP_REFERER']);
    }

    #[NoReturn] public function sendAnswer(): void
    {
        $id=$this->request->inputPOST('request_id');
        $auth = new AuthService();
        $admin_id = $auth->getId();

        $header = $this->request->inputPOST('header_answer');
        $content = $this->request->inputPOST('body_answer');

        //dd([ $id,$admin_id, $header, $content]);
        $support = new SupportRequest();
        $this->logAction('answer', 'request_support', $id, 'Answer successfully');
        $support->setAnswer($id, $admin_id,$header, $content);

        $this->redirect($this->request->server['HTTP_REFERER']);

    }

}