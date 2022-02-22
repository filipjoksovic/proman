<?php 
    class Role{
        public $id;
        public $name;
        public $created_at;
        public $updated_at;

        public function __construct($id,$name,$created_at = null, $updated_at = NULL){
            $this->id = $id;
            $this->name = $name;
            $this->created_at = $created_at;
            $this->updated_at = $updated_at;
        }

        public static function connect(){
            try {
                $connection = new PDO("mysql:host=127.0.0.1;dbname=proman", "root", "");
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $connection;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        public static function getName($role_id){
            $connection = Role::connect();
            $curr = $connection->prepare("SELECT name from roles where id = ?");
            $curr->execute([$role_id]);
            return $curr->fetch()[0];
        }

    }
?>