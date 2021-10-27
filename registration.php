<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!--Imports-->
  <link rel="stylesheet" href="web/libraries/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="web/libraries/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="web/libraries/style.css?version=1.2">

  <!--Logo and title-->
  <title>Internet věcí</title>
  <link rel="shortcut icon" href="favicon.png">
</head>

<body>
  <!--Title-->
  <div class="container-fluid text-center align-self-center" id="title">
    <h1>Konference internet věcí</h1>
  </div>

  <!--Menu-->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="fa fa-home fa-3x" id="home" href="index.html"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link active underline" aria-current="page" href="index.html">Informace</a>
          </li>
          <li class="nav-item">
            <a class="nav-link underline" href="program.html">Program konference</a>
          </li>
        </ul>
        <form class="d-flex">
          <button class="btn btn-primary moveMenuButton" type="button"><span class="fa fa-sign-in"></span>
            Přihlášení</button>
          <button class="btn btn-primary moveMenuButton" type="button"
            onclick="location.href='registration.php'">Registrace</button>
        </form>
      </div>
    </div>
  </nav>
  <h2>Registrace</h2>
  <!--Body-->
  <div class="container" id="form">
    <form action="" method="POST">
      <!--Username-->
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <label for="username" class="form-label">Uživatelská přezdívka:</label>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-username"><i class="fa fa-user"></i></span>
            <input type="text" class="form-control" id="username" aria-describedby="username" placeholder="přezdívka" required>
          </div>
          <!--Full name-->
          <label for="fullName" class="form-label">Celé jméno:</label>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-fullName"><i class="fa fa-user"></i></span>
            <input type="text" class="form-control" id="fullName" aria-describedby="fullName" placeholder="celé jméno" required>
          </div>
          <!--telephone number-->
          <label for="telephone" class="form-label">Telefonní číslo:</label>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-telephone"><i class="fa fa-phone"></i></span>
            <input type="tel" class="form-control" id="telephone" aria-describedby="telephone" placeholder="123 456 789" pattern="[0-9]{3} [0-9]{3} [0-9]{3}" required>
          </div>
          <p id="phoneHelp">Formát: 123 456 789</p>
        </div>
        <div class="col-md-6 col-sm-12">
          <!--Email-->
          <label for="email" class="form-label">Emailová adresa:</label>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-email">@</span>
            <input type="email" class="form-control" id="email" aria-describedby="email" placeholder="e-mail" requried>
          </div>
          <!--password-->
          <label for="password" class="form-label">Heslo:</label>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-password"><i class="fa fa-lock"></i></span>
            <input name="password" type="password" value="" class="input form-control" id="password" placeholder="password" required="true" aria-label="password" aria-describedby="basic-addon1" />
            <span class="input-group-text" onmousedown="password_show_hide();" onmouseup="password_show_hide();">
              <i class="fa fa-eye-slash" id="show_eye"></i>
              <i class="fa fa-eye d-none" id="hide_eye"></i>
            </span>
          </div>
          <label for="password2" class="form-label">Zopakujte heslo:</label>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-password2"><i class="fa fa-lock"></i></span>
            <input type="password" class="form-control" id="password2" aria-describedby="password2" placeholder="password" required>
          </div>
        </div>
      </div>
      <div class="row">
        <p>Už jste zaregistrován/a? <a href="">Přihlásit se</a>
        <p>
      </div>
      <div class="row mx-auto" id="formSubmit">
        <!--Submit-->
        <button type="submit" class="btn btn-primary" value="registration">Registrovat</button>
      </div>
    </form>
  </div>

  <!--arrow-->
  <a href="#"><span class="fa fa-arrow-circle-up fa-4x" id="arrow"></span></a>

  <!--Footer-->
  <div class="alert alert-dark" role="alert" id="footer">
    &copyMiroslav Vdoviak
  </div>

  <!--Javascript import-->
  <script src="web/libraries/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>

  <!--Scripts-->
  <script>
    function password_show_hide() {
      var x = document.getElementById("password");
      var show_eye = document.getElementById("show_eye");
      var hide_eye = document.getElementById("hide_eye");
      hide_eye.classList.remove("d-none");
      if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye.style.display = "block";
      } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye.style.display = "none";
      }
    }
  </script>
</body>

</html>