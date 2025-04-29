<?php

namespace App\Core;

use App\Core\ConnectionDB;

require_once APP_PATH."../config/configDB.php";


class User extends ConnectionDB {
    private ?string $login;
    private ?string $email;
    private ?string $userPassword;
    private ?string $dateCreated;
    private ?int $id;
    private bool $isAdmin;

    public function __construct() {

        
        parent::__construct($DB_HOST, $DB_PORT, $DB_NAME, $DB_USER, $DB_PASSWORD);
    }

    private function isExistLogin($login):bool
    {
        $sql = "SELECT * FROM users WHERE login = ?";
        $stmt =  $this->connection->prepare($sql);
        $stmt->execute([$login]);
        return $stmt->fetchColumn();
    }
    private function isExistEmail($email):bool
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt =  $this->connection->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchColumn();
    }

    public function isValidLogin(string $login):bool
    {
        $flag = (preg_match('/^[a-zA-Z0-9_]{3,20}$/', $login) === 1);
        if(!$flag)
        {
            $this->errors["Login"]="Login uncorrect";
        }
        return $flag;
    }

    public function isValidEmail(string $email):bool
    {
        $flag = (filter_var($email, FILTER_VALIDATE_EMAIL) !== false);
        if(!$flag)
        {
            $this->errors["Email"]="Email uncorrect";
        }
        return $flag;
    }

    public function isValidPassword(string $password):bool
    {
        $flag = (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/', $password) === 1);
        if(!$flag)
        {
            $this->errors["Password"]="Password uncorrect";
        }
        return $flag;
    }

    public function register($login, $email, $passsword):bool
    {
        if ($this->isValidEmail($email) && $this->isValidLogin($login) && $this->isValidPassword($password))
        {
            if(!$this->isExistLogin($login) && !$this->isExistEmail($email))
            {
                $hashPassword = password_hash($password);
                $sql= "INSERT INTO users (login,email,password,created_at,isAdmin) VALUES (?,?,?,NOW(),false)";
                $stmt= $this->connection->prepare($sql);
                $stmt->bindParam($login,$email, $hashPassword);
                return !isset($this->errors);
            }
            else return false;
        }
        else return false;

    }    

   
}