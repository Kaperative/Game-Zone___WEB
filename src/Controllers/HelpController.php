<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Models\SupportRequest;
use App\Models\User;
use App\services\AuthService;
use JetBrains\PhpStorm\NoReturn;
use PHPMailer\PHPMailer\PHPMailer;

require_once APP_PATH . '/vendor/autoload.php';
class HelpController extends Controller
{

    public function index():void
    {
        $this->view->page('/Help/help');
    }

    public function saveSupportRequest():void
    {
        $support= new SupportRequest();
        $auth = new AuthService();
        $support->addRequest($auth->getId(),$this->request->inputPOST('subject'),$this->request->inputPOST('message'));
        $this->sendMail();
        $this->redirect('/help/help');
    }
    #[NoReturn] public function sendMail():void
    {
        $subject =$this->request->inputPOST('subject');
        $message =$this->request->inputPOST('message');
        $files =$this->request->inputPOST('files');
        $auth = new AuthService();

        $email = $auth->getEmail();
        $login = $auth->getLogin();


        $message = "Ваше письмо: ".$subject."   $message  " ." Находится в обработке. Спасибо за обратную свзязь";
        $subject = "Game-Zone support request";
        $mail = new PHPMailer();

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kaperative@gmail.com';
            $mail->Password = 'zryp aajg digu zyhs';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('kaperative@gmail.com', 'Game-Zone Team');
            $mail->addAddress($email,$login);

            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->send();
            echo 'Письмо успешно отправлено!';
        } catch (Exception $e) {
            echo "Ошибка: {$mail->ErrorInfo}";
        }
    }

    public function sendSimpleEmail():bool
    {

        $subject =$this->request->inputPOST('subject');
        $message =$this->request->inputPOST('message');
        $files =$this->request->inputPOST('files');

        $auth = new AuthService();
        $email = $auth->getEmail();
        $defaultHeaders = [
            'From' => 'kaperative@gmail.com',
            'Reply-To' => 'kaperative@gmail.com',
            'Content-Type' => 'text/html; charset=UTF-8'
        ];


        return mail($email, $subject, $message, $defaultHeaders);
    }
}