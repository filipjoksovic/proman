<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proman - Register</title>
    <?php require "components.php"; ?>
</head>

<body>
    <?php require "nav.php"; ?>
    <div class="container my-3">
        <h1>Registracija</h1>
        <form action="index.php" method="post">
            <div class="row my-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fname">Ime</label>
                        <input type="text" class="form-control" name="fname">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lname">Prezime</label>
                        <input type="text" class="form-control" name="lname">
                    </div>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="email">Email adresa</label>
                        <input type="text" id="email" class="form-control" name="email">
                    </div>
                </div>
            </div>
            <div class="row my-2 my-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Lozinka</label>
                        <input type="password" id="password" class="form-control" name="password">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="confirm_password">Potvrda lozinke</label>
                        <input type="password" id="confirm_password" class="form-control" name="confirm_password">
                    </div>
                </div>
                <p id = 'validator_text'></p>
            </div>
            <p>Ukoliko vec imate nalog, prijavite se <a href = "login.php">ovde</a>.</p>
            <button class="btn btn-primary btn-block w-100 my-3">Prijavi se</button>
        </form>
    </div>
    <script src = "js/pVal.js"></script>
</body>

</html>