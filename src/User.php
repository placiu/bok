<?php

class User
{
    private $id;
    private $login;
    private $password;
    private $role;

    public function __construct()
    {
        $this->id = null;
        $this->login = '';
        $this->password = '';
        $this->role = 'client';
    }

    public function saveUser(PDO $db)
    {
            $sql = 'INSERT INTO users(id,login,password,role) VALUES(null, :login, :password, :role)';
            $stmt = $db->prepare($sql);
            $result = $stmt->execute([
                'login' => $this->login,
                'password' => $this->password,
                'role' => $this->role
            ]);
            if ($result) {
                $this->id = $db->lastInsertId();
                return true;
            }
        return false;
    }

    static public function userById(PDO $db, $id)
    {
        $stmt = $db->prepare('SELECT * FROM users WHERE id = :id');
        $result = $stmt->execute(['id' => $id]);
        if ($result && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $user = new User();
            $user->id = $row['id'];
            $user->login = $row['login'];
            $user->password = $row['password'];
            $user->role = $row['role'];
            return $user;
        }
        return false;
    }

    static public function userByLogin(PDO $db, $login)
    {
        $stmt = $db->prepare('SELECT * FROM users WHERE login = :login');
        $result = $stmt->execute(['login' => $login]);
        if ($result && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $user = new User();
            $user->id = $row['id'];
            $user->username = $row['login'];
            $user->password = $row['password'];
            $user->role = $row['role'];
            return $user;
        }
        return false;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

}