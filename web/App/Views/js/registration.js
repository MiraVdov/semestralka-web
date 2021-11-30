let lc = false;
let uc = false;
let num = false;
let len = false;
let samePass = false;
let uniqueLogin = false;
let registrationBtn;

function checkAllConditions(){
    if (lc && uc && num && len && samePass && uniqueLogin)registrationBtn.removeAttr("disabled");
    else registrationBtn.attr('disabled','disabled');
}

let backspace = false;
function numberHelp(number){
    let numText = number.value;
    let numArray = numText.split(' ');
    let numInput = $("#telephone");
    let result = "";

    number.addEventListener('keydown', e =>{
        if (e.code == "Backspace")backspace = true;
        else backspace = false;
    });

    if (backspace) return;

    for (let i = 0; i < numArray.length; i++) {
        for (let j = 0; j < numArray[i].length; j++) {
            if (j < 2) result += numArray[i][j];
            else result += numArray[i][j] + " ";
        }
    }

    if (result.length >= 12)result = result.substring(0,11);
    numInput.val(result);
}

function comparePasswords(){
    let password1 = $("#passwordRegistration");
    let password2 = $("#password2");
    let outputEl = $("#password-text");

    outputEl.empty();

    if (password1.val() != password2.val()){
        outputEl.append("Hesla se neshodují!");
        outputEl.addClass("invalid");
        outputEl.removeClass("valid");
        samePass = false;
    }else{
        outputEl.addClass("valid");
        outputEl.removeClass("invalid");
        outputEl.append("Hesla se shodují!");
        samePass = true;
    }
    checkAllConditions();
}

let userLogins = [];
function compareLoginName(txtLogin){
    let login = txtLogin.value;

    if (userLogins.length == 0){
        $.post(
            "App/models/phpScripts/login-ajax.php",

            {

            },

            // reakce na odpoved
            function (response, status) {
                if (status == "success") {
                    userLogins = response.split(",");
                } else if (status == "error") {
                }
            }
        );
    }

    let isSame = false;
    for (let i = 0; i < userLogins.length; i++) {
        if (userLogins[i].toLowerCase() == login.toLowerCase()){
            isSame = true;
            break;
        }
    }
    let textLogin = $("#text-login");
    textLogin.empty();
    textLogin.css("margin-top", "-2%");

    if ((login.trim() == "" || login.trim() == " ")){
        textLogin.css("margin-top", "3%");
        uniqueLogin = false;
        return;
    }

    if (isSame){
        textLogin.append("Bohužel zadaný login už používá jiný uživatel");
        textLogin.css("color","red");
        uniqueLogin = false;
    }
    else{
        textLogin.append("Zadaný login je volný");
        textLogin.css("color","green");
        uniqueLogin = true;
    }

    checkAllConditions();
}

$(document).ready(function () {
    registrationBtn = $("#registrationID");
    registrationBtn.attr('disabled','disabled');

    let myInput = document.getElementById("passwordRegistration");
    let letter = document.getElementById("letter");
    let capital = document.getElementById("capital");
    let number = document.getElementById("number");
    let length = document.getElementById("length");

    myInput.onkeyup = function() {
        let lowerCaseLetters = /[a-z]/g;
        if(myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
            lc = true;
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        let upperCaseLetters = /[A-Z]/g;
        if(myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
            uc = true;
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        let numbers = /[0-9]/g;
        if(myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
            num = true;
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        if(myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
            len = true;
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }

        checkAllConditions();
    }
})