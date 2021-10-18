<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Imports-->
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">

    <!--Logo and title-->
    <title>Internet věcí</title>
    <link rel="shortcut icon" href="favicon.png">
</head>
<body>
    <!--Title-->
    <div class="container-fluid text-center align-self-center" id="title">
        <h1                                                                                                                               >Konference internet věcí</h1>
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
            <a class="nav-link active" aria-current="page" href="#">Informace</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Program konference</a>
          </li>
        </ul>
        <form class="d-flex">
            <button class="btn btn-primary" type="button">Search</button>
            <button class="btn btn-primary" type="button">Search</button>
        </form>      
      </div>
    </div>
  </nav>

  <!--Body-->
  <div class="container" id="form">
    <form action="" method="POST" >
    <label for="exampleInputEmail1" class="form-label">Uživatelská přezdívka:</label>
      <div class="input-group mb-3">     
        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>      
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="přezdívka" required>      
      </div> 
      <label for="exampleInputEmail1" class="form-label">Celé jméno:</label>
      <div class="input-group mb-3">     
        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>      
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="celé jméno" required>      
      </div> 
    <label for="exampleInputEmail1" class="form-label">Telefonní číslo:</label>
      <div class="input-group mb-3">     
        <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone"></i></span>      
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="telefonní číslo" required>      
      </div>   
      <label for="exampleInputEmail1" class="form-label">Emailová adresa:</label>
      <div class="input-group mb-3">     
        <span class="input-group-text" id="basic-addon1">@</span>      
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="e-mail" requried>      
      </div> 
      <label for="password" class="form-label">Heslo:</label>
      <div class="input-group mb-3">            
        <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock"></i></span>             
        <input name="password" type="password" value="" class="input form-control" id="password" placeholder="password" required="true" aria-label="password" aria-describedby="basic-addon1" />             
          <span class="input-group-text" onclick="password_show_hide();">
            <i class="fa fa-eye-slash" id="show_eye"></i>
            <i class="fa fa-eye d-none" id="hide_eye"></i>
          </span>           
      </div>    
      <label for="exampleInputEmail1" class="form-label">Zopakujte heslo:</label>
      <div class="input-group mb-3">     
        <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock"></i></span>      
        <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="password" required>      
      </div>     
      <button type="submit" class="btn btn-success">Submit</button>
  </form>
  </div>
  <!--Javascript import-->
    <script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>

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