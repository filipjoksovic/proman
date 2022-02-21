<?php
class User
{
    public $fname;
    public $lname;
    public $email;
    public $password;
    public $role_id;
    public $created_at;
    public $updated_at;

    public function __construct($fname, $lname, $email, $password, $role_id, $created_at = NULL, $updated_at = NULL)
    {
        $this->fname = $fname;
        $this->lname = $lname;
        $this->email = $email;
        $this->password = $password;
        $this->role_id = $role_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
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
            return false;
        }
    }
}
