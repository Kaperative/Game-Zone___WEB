<?php

namespace App\Controllers;

use App\Core\Controller\Controller;

class filesController extends Controller
{
    private string $uploadDir = __DIR__ . '/../../public/uploads/';

    public function index(): void
    {

        // Обработка загрузки файла
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $this->handleUpload();
        }

        // Обработка удаления файла
        if (isset($_GET['delete'])) {
            $this->handleDelete($_GET['delete']);
        }

        // Получаем список файлов
        $files = $this->getFileList();

        $this->view->render('files/index', [
            'files' => $files,
            'view' => $this->view,
            'message' => $_SESSION['message'] ?? null
        ]);

        unset($_SESSION['message']);
    }

    private function handleUpload(): void
    {
        $file = $_FILES['file'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['message'] = 'Ошибка загрузки файла';
            return;
        }

        $filename = basename($file['name']);
        $targetPath = $this->uploadDir . $filename;

        // Проверяем существование файла
        if (file_exists($targetPath)) {
            $_SESSION['message'] = 'Файл с таким именем уже существует';
            return;
        }

        // Перемещаем загруженный файл
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $_SESSION['message'] = 'Файл успешно загружен';
        } else {
            $_SESSION['message'] = 'Ошибка при сохранении файла';
        }
    }

    private function handleDelete($filename): void
    {
        $filePath = $this->uploadDir . basename($filename);

        if (file_exists($filePath) && unlink($filePath)) {
            $_SESSION['message'] = 'Файл удален';
        } else {
            $_SESSION['message'] = 'Ошибка при удалении файла';
        }
    }

    private function getFileList(): false|array
    {
        $files = scandir($this->uploadDir);
        return array_filter($files, function($file) {
            return !in_array($file, ['.', '..']);
        });
    }

    public function download(): void
    {
        if(!isset($_GET['nameFile'])) {
        {return;}
    }$filename= $_GET['nameFile'];

        //dd($filename);
        $filePath = $this->uploadDir . basename($filename);

        if (file_exists($filePath)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            readfile($filePath);
            exit;
        }


    }
}