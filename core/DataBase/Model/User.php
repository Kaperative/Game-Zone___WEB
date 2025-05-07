<?php

namespace App\Core\DataBase\Model;

use App\Core\Config\Config;
use App\Core\DataBase\DataBase;
use App\Core\JsonWebToken\JsonWebToken;

class User extends DataBase
{
    private JsonWebToken $jwt;
    private string $table = "users";
    protected Config $config;
    public function __construct()
    {
        $this->jwt = new JsonWebToken();
        $config = new Config();
        parent::__construct($config);
    }

    public function findByLogin(string $login): ?array
    {
        $sql = "SELECT * FROM $this->table WHERE login = :login";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['login' => $login]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM $this->table WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    public function findById($id): ?array
    {

        $id = is_object($id) ? ($id->userID ?? null) : $id;

        $id = (int)$id;

        if ($id <= 0) {
            return null;
        }

        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
       return($stmt->fetch(\PDO::FETCH_ASSOC) ?: null);
    }
    public function verifyPassword(string $login, string $password): bool
    {
        $user = $this->findByLogin($login);
        return $user && password_verify($password, $user['password']);
    }

    public function create(array $userData): bool
    {
        $sql = "INSERT INTO $this->table (login, email, password, created_at) VALUES (:login, :email, :password, :created_at)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'login' => $userData['login'],
            'email' => $userData['email'],
            'password' => password_hash($userData['password'], PASSWORD_DEFAULT),
            'created_at' => $userData['created_at'] ?? time()
        ]);
    }

    public function getID(string $login): ?int
    {
        $stmt = $this->pdo->prepare("SELECT id FROM $this->table WHERE login = :login");
        $stmt->execute(['login' => $login]);

        $result = $stmt->fetchColumn();
        //dd($result);
        return $result !== false ? (int)$result : null;
    }
}