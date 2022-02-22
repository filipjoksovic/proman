<?php
require 'classes/User.php';
require 'classes/Project.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    try {
        if ($action == "create_user") {
            if (strpos($_SERVER['HTTP_REFERER'], "admin.php")) {
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $email = $_POST['email'];
                $password = md5($_POST['password']);
                $role_id = $_POST['role_id'];
                $user = new User($fname, $lname, $email, $password, $role_id);
                if (User::exists($user)) {
                    throw new Exception("Korisnik sa datim podacima vec postoji");
                } else {
                    $result = $user->save();
                    if (is_numeric($result)) {
                        $_SESSION['message'] = "Uspesno kreiran nalog.";
                        header("location:admin.php");
                        return;
                    } else {
                        throw new Exception("Doslo je do greske prilikom kreiranja korisnika. Greska: " . $result);
                    }
                }
            } else {
                throw new Exception("Nemate dozvolu pristupa ovom delu sajta");
            }
        } else if ($action == "delete_user") {
            $user_id = $_POST['user_id'];
            try {
                $result = User::delete($user_id);
                $_SESSION['message'] = "Uspesno uklonjen korisnik iz baze podataka.";
                echo $result;
            } catch (Exception $e) {
                $_SESSION['errors'] = $e->getMessage();
                echo false;
            }
        } else if ($action == "edit_user") {
            $user_id = $_POST['user_id'];
            try {
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $email = $_POST['email'];
                $user = User::find($user_id);
                $user->fname = $fname;
                $user->lname = $lname;
                $user->email = $email;
                $result = $user->update();
                if (!$result) {
                    throw new Exception("Doslo je do greske prilikom izmene korisnika.");
                } else {
                    $_SESSION['message'] = "Uspesno izmenjen korisnik";
                    header("location:" . $_SERVER['HTTP_REFERER']);
                }
            } catch (Exception $e) {
                $_SESSION['errors'] = $e->getMessage();
                header("location:" . $_SERVER['HTTP_REFERER']);
            }
            return;
        } else if ($action == "edit_project") {
            try {
                $project_id = $_POST['project_id'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                $benefits = $_POST['benefits'];
                $location = $_POST['location'];
                $deadline = $_POST['deadline'];
                $education = $_POST['education'];
                $manager_id = $_SESSION['uid'];

                $project = Project::find($project_id);
                $project->name = $name;
                $project->description = $description;
                $project->benefits = $benefits;
                $project->location = $location;
                $project->deadline = $deadline;
                $project->education = $education;
                $project->manager_id = $manager_id;

                $result = $project->update();
                echo $result;
                if ($result === true) {
                    $_SESSION['message'] = "Uspesno izmenjen projekat";
                } else {
                    throw new Exception("Doslo je do greske prilikom izmene projekta. Greska: " . $result);
                }
            } catch (Exception $e) {
                $_SESSION['errors'] = $e->getMessage();
            }
            return;
        } else if ($action == "delete_project") {
            try {
                $project_id = $_POST['project_id'];
                $project = Project::find($project_id);
                $result = $project->delete();
                $_SESSION['message'] = "Uspesno uklonjen projekat iz baze podataka.";
            } catch (Exception $e) {
                $_SESSION['errors'] = $e->getMessage();
            }
            return;
        }
    } catch (Exception $e) {
        $_SESSION['errors'] = $e->getMessage();
        header("location:" . $_SERVER['HTTP_REFERER']);
        return;
    }
} elseif (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == "get_user_data") {
        $user_id = $_GET['user_id'];
        try {
            $user = User::find($user_id);
            if ($user == null) {
                throw new Exception("Korisnik sa datim podacima ne postoji");
            } else {
                echo json_encode($user);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } else if ($action == "get_project") {
        $project_id = $_GET['project_id'];
        try {
            $project = Project::find($project_id);
            if ($project == null) {
                throw new Exception("Projekat sa zadatim parametrima nije pronadjen");
            } else {
                echo json_encode($project);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
} else {

    if (strpos($_SERVER['HTTP_REFERER'], "register.php")) {
        try {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $confirm_password = md5($_POST['confirm_password']);
            $role_id = $_POST['role_id'];
            if ($role_id < 1 || $role_id > 2) {
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

    if (strpos($_SERVER['HTTP_REFERER'], "login.php")) {
        try {
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $user = User::auth($email, $password);
            if ($user == null) {
                throw new Exception("Neispravni podaci za prijavu na nalog. Proverite podatke i pokusajte ponovo.");
            } else {
                $_SESSION['uid'] = $user->id;
                $_SESSION['fname'] = $user->fname;
                $_SESSION['lname'] = $user->lname;
                $_SESSION['message'] = "Uspesna prijava.";
                if ($user->role_id == 1) {
                    header("location:main.php");
                    return;
                } else if ($user->role_id == 2) {
                    header("location:manager.php");
                    return;
                } else if ($user->role_id == 3) {
                    header("location:admin.php");
                    return;
                }
            }
        } catch (Exception $e) {
            $_SESSION['errors'] = $e->getMessage();
            header("location:login.php");
        }
    }
    if (strpos($_SERVER['HTTP_REFERER'], "addProject.php")) {
        try {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $benefits = $_POST['benefits'];
            $location = $_POST['location'];
            $deadline = $_POST['deadline'];
            $education = $_POST['education'];
            $manager_id = $_SESSION['uid'];
            $project = new Project($name, $description, $location, $education, $benefits, $manager_id, $deadline);
            $result = $project->save();

            if (!is_numeric($result)) {
                throw new Exception("Doslo je do greske prilikom kreiranja projekta. Greska: " . $result);
            } else {
                $_SESSION['message'] = "Uspesno kreiran projekat";
                header("location:manager.php");
                return;
            }
        } catch (Exception $e) {
            $_SESSION['errors'] = $e->getMessage();
            header("location:" . $_SERVER['HTTP_REFERER']);
            return;
        }
    }
}
