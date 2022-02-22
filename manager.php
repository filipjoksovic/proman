<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proman - Menadzer</title>
    <?php require "components.php"; ?>
</head>

<body>
    <?php require "nav.php"; ?>
    <?php
    require "classes/Project.php";
    $projects = Project::getProjects($_SESSION['uid']);
    ?>

    <div class="container my-3">
        <h1>Menadzer pocetna</h1>
        <a class="btn d-block w-50 mx-auto btn-primary" href="addProject.php">Dodaj novi projekat</a>
        <?php if ($projects == null) : ?>
            <h2 class = "mt-4">Doslo je do greske prilikom prikupljanja projekta iz baze.</h2>
        <?php elseif (count($projects) == 0) : ?>
            <h2 class = "mt-4">Nemate ni jedan dodat projekat.</h2>
        <?php else : ?>
            <h2 class = "mt-4">Dostupni projekti</h2>
        <?php endif; ?>
    </div>

</body>

</html>