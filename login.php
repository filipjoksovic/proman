<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proman - Login</title>
    <?php require "components.php"; ?>
</head>

<body>
    <?php require "nav.php"; ?>
    <div class="container my-3">
        <h1>Prijava</h1>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="email">Email adresa</label>
                <input class="form-control" name="email" type="email" id="email" placeholder="aleksandarpetrovic@gmail.com">
            </div>
            <div class="form-group">
                <label for="password">Lozinka</label>
                <input class="form-control" name="password" type="password" id="password">
            </div>
            <p>Ukoliko vec nemate nalog, registrujte se <a href="register.php">ovde</a>.</p>
            <button class="btn btn-primary btn-block w-100" type="submit">Prijavi se</button>
        </form>
    </div>
</body>

</html>