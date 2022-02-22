<?php
require "classes/User.php";
$users = User::getAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proman - Administrator</title>
  <?php require "components.php"; ?>
</head>

<body>
  <?php require "nav.php"; ?>
  <div class="container my-3">
    <h1>Administrator</h1>
    <form action="index.php" method="POST" class="my-3">
      <input type="hidden" name="action" value="create_user">
      <h1>Kreiraj korisnika</h1>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="fname">Ime</label>
            <input class="form-control" type="text" name="fname" id="fname">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="lname">Prezime</label>
            <input class="form-control" type="text" name="lname" id="lname">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="password">Lozinka</label>
            <input class="form-control" type="password" name="password" id="password">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="role_id">Rola</label>
            <select class="form-control" name="role_id" id="role_id">
              <option value="1">Korisnik</option>
              <option value="2">Menadzer</option>

            </select>
          </div>
        </div>
      </div>
      <button class="btn d-block w-50 mx-auto btn-primary my-2">Kreiraj korisnika</button>

    </form>

    <?php if ($users == null) : ?>
      <h1 class="text-center">Doslo je do greske prilikom preuzimanja korisnika.</h1>
    <?php elseif (count($users) == 1) : ?>
      <h1 class="text-center">U bazi ne postoji ni jedan korisnik sem Vas.</h1>
    <?php else : ?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <th>ID</th>
            <th>Ime</th>
            <th>Prezime</th>
            <th>Email</th>
            <th>Uloga</th>
            <th>Datum kreiranja</th>
            <th>Datum azuriranja</th>
            <th>Izmeni</th>
            <th>Ukloni</th>

          </thead>
          <tbody>
            <?php foreach ($users as $user) : ?>
              <?php if ($user->id != $_SESSION['uid']) : ?>
                <tr>
                  <?php foreach ($user as $key => $value) : ?>
                    <?php if ($key != "password") : ?>
                      <td><?php echo $value; ?></td>
                    <?php endif; ?>
                  <?php endforeach; ?>
                  <td><button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" onClick="initiateEdit(<?php echo $user->id; ?>)">Izmeni</button></td>
                  <td><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onClick="initiateDelete(<?php echo $user->id; ?>)">Ukloni</button></td>

                </tr>
              <?php endif; ?>
            <?php endforeach; ?>
          </tbody>

        </table>
      </div>
    <?php endif; ?>
  </div>

  <!--Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Izmena korisnika</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="index.php" method="POST" class="my-3">
            <input type="hidden" name="action" value="edit_user">
            <input type="hidden" name="user_id" id="edit_user_id">
            <h1>Izmena korisnika</h1>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="editFname">Ime</label>
                  <input class="form-control" type="text" name="fname" id="editFname">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="editLname">Prezime</label>
                  <input class="form-control" type="text" name="lname" id="editLname">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="editEmail">Email</label>
                  <input class="form-control" type="email" name="email" id="editEmail">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="edit_cat">Datum kreiranja</label>
                  <input type="datetime" id="edit_cat" disabled class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="edit_uat">Poslednje azuriranje</label>
                  <input type="datetime" id="edit_uat" disabled class="form-control">
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button  class="btn btn-primary" type="submit">Potvrdi</button>
        </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Delete modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Brisanje korisnika</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Potvrdom ove akcije uklonicete korisnika sa <span id="deleteEmailPlaceholder"></span>. Nastavite?
          <input type="hidden" id="delete_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" onclick="confirmUserDelete()">Potvrdi</button>
        </div>
      </div>
    </div>
  </div>
  <script src="js/users.js"></script>
</body>

</html>