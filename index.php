<?php
require 'classes/User.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (strpos($_SERVER['HTTP_REFERER'], "register.php")) {
    try {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $confirm_password = md5($_POST['confirm_password']);
        $role_id = $_POST['role_id'];
        if($role_id < 1 || $role_id > 2){
            throw new Exception("Odabrana vrednost za rolu nije dozvoljena");
        }
        if ($password != $confirm_password) {
            throw new Exception("Lozinke se ne podudaraju.");
        } else {
            $user = new User($fname, $lname, $email, $password, $role_id);
            if (User::exists($user)) {
                throw new Exception("Korisnik sa datim podacima vec postoji");
            } else {
                $result = $user->save();
                if ($result) {
                    $_SESSION['message'] = "Uspesno registrovan nalog. Dobrodosli, {$fname} {$lname}";
                    $_SESSION['uid'] = $result;
                    $_SESSION['fname'] = $fname;
                    $_SESSION['lname'] = $lname;
                    if ($role_id == 1) {
                        header("location:main.php");
                    } else if ($role_id == 2) {
                        header("location:manager.php");
                    } else if ($role_id == 3) {
                        header("location:admin.php");
                    }
                } else {
                    throw new Exception("Doslo je do greske prilikom kreiranja korisnika");
                }
            }
        }
    } catch (Exception $e) {
        $_SESSION['errors'] = $e->getMessage();
        header("location:register.php");
    }
}
