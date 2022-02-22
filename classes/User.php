<?php
require "Role.php";
class User
{
    public $id;
    public $fname;
    public $lname;
    public $email;
    public $password;
    public $role_id;
    public $created_at;
    public $updated_at;

    public function __construct($fname, $lname, $email, $password, $role_id, $created_at = NULL, $updated_at = NULL, $id = NULL)
    {
        $this->fname = $fname;
        $this->lname = $lname;
        $this->email = $email;
        $this->password = $password;
        $this->role_id = $role_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->id = $id;
    }
    public static function connect()
    {
        try {
            $connection = new PDO("mysql:host=127.0.0.1;dbname=proman", "root", "");
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function exists($user)
    {
        $connection = User::connect();
        $curr = $connection->prepare("SELECT * FROM users where email = ? LIMIT 1");
        $curr->execute([$user->email]);
        return (count($curr->fetchAll()) > 0);
    }
    public function save()
    {
        try {
            $connection = User::connect();
            $curr = $connection->prepare("INSERT INTO users(fname,lname,email,password,role_id) VALUES(?,?,?,?,?)");
            $curr->execute([$this->fname, $this->lname, $this->email, $this->password, $this->role_id]);
            return $connection->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function auth($email, $password)
    {
        try {
            $connection = User::connect();
            $curr = $connection->prepare("SELECT * from users where email = ? AND password = ? LIMIT 1");
            $curr->execute([$email, $password]);
            $row = $curr->fetchObject();
            if (!$row) {
                return null;
            }
            $user = new User($row->fname, $row->lname, $row->email, $row->password, $row->role_id, $row->created_at, $row->updated_at, $row->id);
            return $user;
        } catch (PDOException $e) {
            return null;
        }
    }
    public static function getAll()
    {
        try {
            $connection = User::connect();
            $curr = $connection->prepare("SELECT * FROM users");
            $curr->execute();
            $rows = $curr->fetchAll(PDO::FETCH_OBJ);
            $users = [];
            $i = 0;
            foreach ($rows as $row) {
                $users[$i] = new User($row->fname, $row->lname, $row->email, $row->password, $row->role_id, $row->created_at, $row->updated_at, $row->id);
                $users[$i]->role_id = Role::getName($users[$i]->role_id);
                $i++;
            }
            return $users;
        } catch (PDOException $e) {
            return null;
        }
    }
    public static function find($id)
    {
        try {
            $connection = User::connect();
            $curr = $connection->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
            $curr->execute([$id]);
            $row = $curr->fetchObject();
            return  new User($row->fname, $row->lname, $row->email, $row->password, $row->role_id, $row->created_at, $row->updated_at, $row->id);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id)
    {
        try {
            $connection = User::connect();
            $curr = $connection->prepare("DELETE FROM users where id = ?");
            $curr->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function update()
    {
        try {
            $connection = User::connect();
            $curr = $connection->prepare("UPDATE users set fname = ?, lname = ?, email = ? WHERE id = ?");
            $curr->execute([$this->fname, $this->lname, $this->email, $this->id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
