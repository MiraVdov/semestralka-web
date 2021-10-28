<?php

namespace app\Views;

/**
 * Trida obsahujici zakladni sablony
 */
class BasicTemplate
{
    /**
     * Sablona pro hlavicku
     * @param string $pageTitle
     */
    public function getHeader(string $pageTitle)
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <!--Imports-->
            <link rel="stylesheet" href="libraries/bootstrap-5.0.2-dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="libraries/font-awesome-4.7.0/css/font-awesome.min.css">

            <link rel="stylesheet" href="libraries/style.css?version=1.4">

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
                <a class="fa fa-home fa-3x" id="home" href="index.php?page=information"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown"
                        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active underline" aria-current="page" href="index.php?page=information">Informace</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link underline" href="index.php?page=program">Program konference</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <button class="btn btn-primary moveMenuButton" type="button" id="btnLogin"><span
                                    class="fa fa-sign-in"></span>
                            Přihlášení
                        </button>
                        <button class="btn btn-primary moveMenuButton" type="button"
                                onclick="location.href='index.php?page=registration'">Registrace
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!--Login form-->
        <div id="loginForm">
            <form method="post">
                <button type="button" class="btn-close" aria-label="Close" id="closeButton"></button>
                <!--Username-->
                <h3>Přihlášení</h3>
                <label for="username" class="form-label">Uživatelská přezdívka:</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-username"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" name="login" id="username" aria-describedby="username"
                           placeholder="přezdívka" required>
                </div>
                <!--password-->
                <label for="password" class="form-label">Heslo:</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-password"><i class="fa fa-lock"></i></span>
                    <input name="password" type="password" name="password" class="input form-control" id="password"
                           placeholder="password" required="true" aria-label="password"
                           aria-describedby="basic-addon1"/>
                    <span class="input-group-text" onmousedown="password_show_hide();"
                          onmouseup="password_show_hide();">
                    <i class="fa fa-eye-slash" id="show_eye"></i>
                    <i class="fa fa-eye d-none" id="hide_eye"></i>
                </span>
                </div>
                <p>Zapomněli jste své heslo? <a href="#">Obnovte si ho zde</a></p>
                <button type="submit" name="action" value="login" class="btn btn-primary">Přihlásit se</button>
                <br><br>
                Nemáte ještě účet? <a href="index.php?page=registration">Zaregistrujte se zde</a>
            </form>
        </div>
        <?php
    }

    /**
     * Sablona pro registracni formular
     */
    public function getRegistrationForm(){
        ?>

        <!--Body-->
        <div class="container" id="form">
            <h3>Registrace</h3>
            <form action="" method="POST">
                <!--Username-->
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="username" class="form-label">Uživatelská přezdívka:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-username"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" name="username" id="username" aria-describedby="username"
                                   placeholder="přezdívka" required>
                        </div>
                        <!--Full name-->
                        <label for="fullName" class="form-label">Celé jméno:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-fullName"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" name="fullName" id="fullName" aria-describedby="fullName"
                                   placeholder="celé jméno" required>
                        </div>
                        <!--telephone number-->
                        <label for="telephone" class="form-label">Telefonní číslo:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-telephone"><i class="fa fa-phone"></i></span>
                            <input type="tel" class="form-control" name="telephone" id="telephone" aria-describedby="telephone"
                                   placeholder="123 456 789" pattern="[0-9]{3} [0-9]{3} [0-9]{3}" required>
                        </div>
                        <p id="phoneHelp">Formát: 123 456 789</p>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!--Email-->
                        <label for="email" class="form-label">Emailová adresa:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-email">@</span>
                            <input type="email" class="form-control" name="email" id="email" aria-describedby="email"
                                   placeholder="e-mail">
                        </div>
                        <!--password-->
                        <label for="password" class="form-label">Heslo:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-password"><i class="fa fa-lock"></i></span>
                            <input name="password" type="password" value="" class="input form-control" id="password"
                                   placeholder="password" aria-label="password"
                                   aria-describedby="basic-addon1" required/>
                            <span class="input-group-text" onmousedown="password_show_hide();" onmouseup="password_show_hide();">
                              <i class="fa fa-eye-slash" id="show_eye"></i>
                              <i class="fa fa-eye d-none" id="hide_eye"></i>
                            </span>
                        </div>
                        <label for="password2" class="form-label">Zopakujte heslo:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-password2"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password2" class="form-control" id="password2" aria-describedby="password2"
                                   placeholder="password" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <p>Už jste zaregistrován/a? <a id="loginFade">Přihlásit se</a>
                    <p>
                </div>
                <div class="row mx-auto" id="formSubmit">
                    <!--Submit-->
                    <button type="submit" class="btn btn-primary" name="action" value="registration">Registrovat</button>
                </div>
            </form>
        </div>
        <?php
    }

    /**
     * Sablona pro telo
     */
    public function getFooter()
    {
        ?>
        <!--arrow-->
        <a href="#"><span class="fa fa-arrow-circle-up fa-4x" id="arrow"></span></a>

        <!--Footer-->
        <div class="alert alert-dark" role="alert" id="footer">
            &copyMiroslav Vdoviak
        </div>

        <!--Javascript import-->
        <script src="libraries/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
        <!--jquery import-->
        <script src="libraries/jquery/jquery-3.5.1.min.js"></script>

        <!--scripts-->
        <script>
            $(document).ready(function () {
                $("#btnLogin, #loginFade").click(function () {
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

    /**
     * Metoda vraci lorep ipsum informaci
     */
    public function getInformationLorem()
    {
        ?>
        <div class="container">
            <h3>Program</h3>
            <?php $this->getLoremText(); ?>
        </div>
        <?php
    }

    /**
     * Metoda vraci lorem ipsum programu
     */
    public function getProgramLorem()
    {
        ?>
        <div class="container">
            <h3>Program</h3>

            <ul>
                <li><strong>6:00 - 8:00</strong> - Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam
                    erat
                    volutpat. Morbi sceleri.
                </li>
                <li><strong>8:00 - 12:00</strong> - Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam
                    erat
                    volutpat. Morbi sceleri.
                </li>
                <li><strong>12:00 - 14:00</strong> - Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam
                    erat
                    volutpat. Morbi sceleri.
                </li>
                <li><strong>14:00 - 20:00</strong> - Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam
                    erat
                    volutpat. Morbi sceleri.
                </li>
                <li><strong>20:00 - 00:00</strong> - Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam
                    erat
                    volutpat. Morbi sceleri.
                </li>
            </ul>
            <?php $this->getLoremText(); ?>
        </div>
        <?php
    }

    /**
     * Metoda vrací alert boxy
     */
    public function getAlertBoxes()
    {
        ?>
        <div class="alert alert-info alert-dismissible fade show alert1">
            <strong>Informace - </strong> 5.01.2022 se uskuteční v arealu zču v Plzni konference na téma <strong>Internet
                věcí.</strong> Všichni jsou srdečně zváni.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <div class="alert alert-danger alert-dismissible fade show alert1" class="alert">
            <strong>Upozornění!</strong> 20.07.2022 dojde k výpadku stránky z důvodu údržby. Děkujeme za pochopení.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <?php
    }

    /**
     * Lorem ipsum sablona
     */
    private function getLoremText()
    {
        ?>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam erat volutpat. Morbi scelerisque luctus
            velit.
            Maecenas fermentum, sem in pharetra pellentesque, velit turpis volutpat ante, in pharetra metus odio a
            lectus. Sed
            ac dolor sit amet purus malesuada congue. Phasellus et lorem id felis nonummy placerat. Aenean fermentum
            risus id
            tortor. Aliquam erat volutpat. Mauris elementum mauris vitae tortor. Aliquam ornare wisi eu metus.
            Curabitur
            bibendum justo non orci. Nulla non arcu lacinia neque faucibus fringilla. Nam sed tellus id magna
            elementum
            tincidunt. Duis pulvinar. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip
            ex ea
            commodo consequat. Curabitur vitae diam non enim vestibulum interdum. Cras elementum. Etiam ligula pede,
            sagittis
            quis, interdum ultricies, scelerisque eu. Vivamus porttitor turpis ac leo.</p>

        <p>Aenean fermentum risus id tortor. Curabitur vitae diam non enim vestibulum interdum. Class aptent taciti
            sociosqu
            ad litora torquent per conubia nostra, per inceptos hymenaeos. Proin mattis lacinia justo. Integer
            malesuada. Cras
            elementum. Duis condimentum augue id magna semper rutrum. Et harum quidem rerum facilis est et expedita
            distinctio. Suspendisse sagittis ultrices augue. Cras pede libero, dapibus nec, pretium sit amet, tempor
            quis.
            Quisque tincidunt scelerisque libero. Cras pede libero, dapibus nec, pretium sit amet, tempor quis. Sed
            elit
            dui,
            pellentesque a, faucibus vel, interdum nec, diam. Nam sed tellus id magna elementum tincidunt. Quisque
            porta.
            Integer malesuada. Vivamus luctus egestas leo. Etiam commodo dui eget wisi.</p>

        <p>Nam quis nulla. Fusce suscipit libero eget elit. Duis viverra diam non justo. Proin mattis lacinia justo.
            Aliquam
            erat volutpat. Donec quis nibh at felis congue commodo. Praesent dapibus. Et harum quidem rerum facilis
            est
            et
            expedita distinctio. Vivamus porttitor turpis ac leo. Proin mattis lacinia justo. Aenean fermentum risus
            id
            tortor. Maecenas libero. Vivamus luctus egestas leo. Fusce consectetuer risus a nunc. Sed ac dolor sit
            amet
            purus
            malesuada congue. Fusce tellus.</p>

        <p>Aliquam erat volutpat. Maecenas ipsum velit, consectetuer eu lobortis ut, dictum at dui. Cum sociis
            natoque
            penatibus et magnis dis parturient montes, nascetur ridiculus mus. Itaque earum rerum hic tenetur a
            sapiente
            delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores
            repellat.
            Mauris tincidunt sem sed arcu. Nullam feugiat, turpis at pulvinar vulputate, erat libero tristique
            tellus,
            nec
            bibendum odio risus sit amet ante. Nam sed tellus id magna elementum tincidunt. Etiam sapien elit,
            consequat
            eget,
            tristique non, venenatis quis, ante. Etiam dui sem, fermentum vitae, sagittis id, malesuada in, quam.
            Nam
            libero
            tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat
            facere
            possimus, omnis voluptas assumenda est, omnis dolor repellendus. Aliquam ante. Aliquam erat volutpat.
            Aenean
            placerat. Etiam posuere lacus quis dolor.</p>

        </div>
        <?php
    }
}