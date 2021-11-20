//funkce slouzi  zobrazeni loginu
$(document).ready(function () {
    $("#btnLogin, #loginFade").click(function () {
        $("#loginForm").fadeIn();
    });

    // funkce slouzi k zavreni loginu
    $("#closeButton").click(function () {
        $("#loginForm").fadeOut();
    });
});

// funkce slouzi k zobrazeni hesel
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

// metoda slouzi k zobrazeni hesel
function password_show_hide2() {
    var x = document.getElementById("passwordRegistration");
    var show_eye = document.getElementById("show_eye2");
    var hide_eye = document.getElementById("hide_eye2");
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