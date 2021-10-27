<?php

    namespace app\Views;

    class BasicTemplate
    {
        public static function getHeader(string $pageTitle){
            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">

                <!--Imports-->
                <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
                <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
                <link rel="stylesheet" href="style.css?version=1.8">

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
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNavDropdown"
                            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
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
                            <button class="btn btn-primary moveMenuButton" type="button" id="btnLogin"><span
                                    class="fa fa-sign-in"></span>
                                Přihlášení
                            </button>
                            <button class="btn btn-primary moveMenuButton" type="button"
                                    onclick="location.href='registration.php'">Registrace
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <!--Login form-->
            <div id="loginForm">
                <form>
                    <button type="button" class="btn-close" aria-label="Close" id="closeButton"></button>
                    <!--Username-->
                    <h3>Přihlášení</h3>
                    <label for="username" class="form-label">Uživatelská přezdívka:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-username"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" id="username" aria-describedby="username"
                               placeholder="přezdívka" required>
                    </div>
                    <!--password-->
                    <label for="password" class="form-label">Heslo:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-password"><i class="fa fa-lock"></i></span>
                        <input name="password" type="password" value="" class="input form-control" id="password"
                               placeholder="password" required="true" aria-label="password"
                               aria-describedby="basic-addon1"/>
                        <span class="input-group-text" onmousedown="password_show_hide();"
                              onmouseup="password_show_hide();">
                    <i class="fa fa-eye-slash" id="show_eye"></i>
                    <i class="fa fa-eye d-none" id="hide_eye"></i>
                </span>
                    </div>
                    <p>Zapomněli jste své heslo? <a href="#">Obnovte si ho zde</a></p>
                    <button type="submit" class="btn btn-primary">Přihlásit se</button>
                    <br><br>
                    Nemáte ještě účet? <a href="registration.php">Zaregistrujte se zde</a>
                </form>
            </div>
            <?php
}

        public static function getFooter(){
            ?>
            <!--arrow-->
            <a href="#"><span class="fa fa-arrow-circle-up fa-4x" id="arrow"></span></a>

            <!--Footer-->
            <div class="alert alert-dark" role="alert" id="footer">
                &copyMiroslav Vdoviak
            </div>

            <!--Javascript import-->
            <script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
            <!--jquery import-->
            <script src="jquery/jquery-3.5.1.min.js"></script>

            <!--scripts-->
            <script>
                $(document).ready(function () {
                    $("#btnLogin").click(function () {
                        $("#loginForm").fadeIn();
                    });
                });

                $(document).ready(function () {
                    $("#closeButton").click(function () {
                        $("#loginForm").fadeOut();
                    });
                });

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
            <?php
        }
    }