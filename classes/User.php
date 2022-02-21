<?php 
    class User{
        public $fname;
        public $lname;
        public $email;
        public $password;
        public $role_id;
        public $created_at;
        public $updated_at;

        public function __construct($fname,$lname,$email,$password,$role_id,$created_at = NULL, $updated_at = NULL){
            $this->fname = $fname;
            $this->lname = $lname;
            $this->email = $email;
            $this->password = $password;
            $this->role_id = $role_id;
            $this->created_at = $created_at;
            $this->updated_at = $updated_at;
        }
        public static function connect(){
            try{
                $connection = new PDO("mysql:host=127.0.0.1;dbname=proman","root","");
                $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return $connection;
            }
            catch(PDOException $e){
                return $e->getMessage();
            }
        }
        public static function exists($user){
            
        }
        public function save(){

        }
    }
?>