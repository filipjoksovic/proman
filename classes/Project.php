<?php
class Project
{
    public $id;
    public $name;
    public $description;
    public $benefits;
    public $location;
    public $education;
    public $manager_id;
    public $deadline;
    public $created_at;
    public $updated_at;

    public function __construct($name, $description, $location, $education, $benefits, $manager_id, $deadline, $created_at = null, $updated_at = null, $id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->location = $location;
        $this->education = $education;
        $this->benefits = $benefits;
        $this->manager_id = $manager_id;
        $this->deadline = $deadline;
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
    public function save()
    {
        try {
            $connection = Project::connect();
            $curr = $connection->prepare("INSERT INTO projects(name,description,location,education,benefits,manager_id,deadline) VALUES(?,?,?,?,?,?,?)");
            $curr->execute([$this->name, $this->description, $this->location, $this->education, $this->benefits, $this->manager_id, $this->deadline]);
            return $connection->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function update()
    {
        try {
            $connection = Project::connect();
            $curr = $connection->prepare("UPDATE projects set name = ?, description = ?, location = ?, education = ?, benefits = ?, deadline = ? WHERE id = ?");
            $curr->execute([$this->name, $this->description, $this->location, $this->education, $this->benefits, $this->deadline, $this->id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function delete()
    {
        try {
            $connection = Project::connect();
            $curr = $connection->prepare("DELETE FROM projects where id = ?");
            $curr->execute([$this->id]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public static function getProjects($id)
    {
        try {
            $connection = Project::connect();
            $curr = $connection->prepare("SELECT * FROM projects WHERE manager_id = ?");
            $curr->execute([$id]);
            $rows = $curr->fetchAll(PDO::FETCH_OBJ);
            $projects = [];
            foreach ($rows as $row) {
                $projects[] = new Project($row->name, $row->description, $row->location, $row->education, $row->benefits, $row->manager_id, $row->deadline, $row->created_at, $row->updated_at, $row->id);
            }
            return $projects;
        } catch (PDOException $e) {
            return null;
        }
    }
    public static function find($id)
    {
        try {
            $connection = Project::connect();
            $curr = $connection->prepare("SELECT * FROM projects WHERE id = ?");
            $curr->execute([$id]);
            $row = $curr->fetchObject();
            $project = new Project($row->name, $row->description, $row->location, $row->education, $row->benefits, $row->manager_id, $row->deadline, $row->created_at, $row->updated_at, $row->id);
            return $project;
        } catch (PDOException $e) {
            return null;
            return $e->getMessage();
        }
    }
}
