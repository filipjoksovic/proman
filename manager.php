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
            <h2 class="mt-4">Doslo je do greske prilikom prikupljanja projekta iz baze.</h2>
        <?php elseif (count($projects) == 0) : ?>
            <h2 class="mt-4">Nemate ni jedan dodat projekat.</h2>
        <?php else : ?>
            <h2 class="mt-4">Dostupni projekti</h2>
            <div class="row">

                <?php foreach ($projects as $project) : ?>
                    <div class="card col-md-6">
                        <div class="card-body  text-center">
                            <h4 class="">
                                <?php echo $project->name; ?>
                            </h4>
                            <div class="row align-items-center">
                                <div class="col-sm-7">
                                    <span>Opis: <strong><?php echo $project->description; ?></strong></span><br>
                                    <span>Benefiti: <strong><?php echo $project->benefits; ?></strong></span><br>
                                    <span>Lokacija: <strong><?php echo $project->location; ?></strong></span><br>
                                    <span>Strucna sprema: <strong><?php echo $project->education; ?></strong></span><br>
                                    <span>Rok zavrsetka: <strong><?php echo $project->deadline; ?></strong></span>
                                </div>
                                <div class="col-sm-5">
                                    <div class="d-flex align-items-center flex-column justify-content-around">
                                        <button data-bs-toggle="modal" data-bs-target="#editModal" onclick="prepareProjectEdit(<?php echo $project->id; ?>)" class="btn btn-warning w-50 my-1">Izmeni</button>
                                        <a href="details.php?id=<?php echo $project->id; ?>" class="btn btn-primary w-50 my-1">Aktivnosti</a>
                                        <button data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="prepareProjectDelete(<?php echo $project->id; ?>)" class="btn btn-danger w-50 my-1">Ukloni</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Izmena projekta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="index.php" method="POST">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="editName">Naziv projekta</label>
                                    <input name="name" id="editName" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editDescription">Opis</label>
                                    <textarea name="editDescription" id="editDescription" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editBenefits">Benefiti</label>
                                    <textarea name="editBenefits" id="editBenefits" class="form-control"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editLocation">Lokacija</label>
                                    <input name="editLocation" id="editLocation" class="form-control">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="deadlineEdit">Rok zavrsetka</label>
                                    <input type="date" name="deadlineEdit" id="deadlineEdit" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="editEducation">Strucna sprema</label>
                                    <select name="editEducation" id="editEducation" class="form-control">
                                        <option value="IV">IV</option>
                                        <option value="V">V</option>
                                        <option value="VI-1">VI-1</option>
                                        <option value="VI-2">VI-2</option>
                                        <option value="VII">VII</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitEdit()">Izmeni</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ukloni projekat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Uklanjanjem ovog projekta iz baze podataka ujedno cete ukloniti sve aktivnosti vezane za njega kao i svaku zasebnih korisnika koji su ucestvovali na njemu.<br>
                    <strong>Nastavite?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
                    <button type="button" class="btn btn-danger" onclick="submitDelete()">Potvrdi</button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/manager.js"></script>
</body>

</html>