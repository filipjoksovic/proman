<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proman - Dodaj projekat</title>
    <?php require "components.php"; ?>
</head>

<body>
    <?php require "nav.php"; ?>
    <div class="container my-3">
        <h1>Kreiranje projekta</h1>
        <form action="index.php" method="POST">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Naziv projekta</label>
                        <input name="name" id="name" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description">Opis</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="benefits">Benefiti</label>
                        <textarea name="benefits" id="benefits" class="form-control"></textarea>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="location">Lokacija</label>
                        <input name="location" id="location" class="form-control">
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="location">Rok zavrsetka</label>
                        <input type="date" name="deadline" id="deadline" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="education">Strucna sprema</label>
                        <select name="education" id="education" class = "form-control">
                            <option value="IV">IV</option>
                            <option value="V">V</option>
                            <option value="VI-1">VI-1</option>
                            <option value="VI-2">VI-2</option>
                            <option value="VII">VII</option>
                        </select>
                    </div>
                </div>
            </div>
            <button class=" my-2 btn btn-primary d-block mx-auto" type="submit">Kreiraj projekat</button>
        </form>
    </div>
</body>

</html>