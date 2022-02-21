<?php
require 'classes/User.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['uid']) || $_SESSION['uid'] == null) {
    header("location:login.php");
} else {
    if (strpos($_SERVER['HTTP_REFERER'], "register.php")) {
        try {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $role_id = $_POST['role_id'];
            if ($password != $confirm_password) {
                throw new Exception("Lozinke se ne podudaraju.");
            } else {
                $user = new User($fname, $lname, $email, $password, $role_id);
                if(User::exists($user)){
                    throw new Exception("Korisnik sa datim podacima vec postoji");
                }
                else{
                    $result = $user->save();
                }
            }
        } catch (Exception $e) {
            $_SESSION['errors'] = $e->getMessage();
            header("location:register.php");
        }
    }
}
