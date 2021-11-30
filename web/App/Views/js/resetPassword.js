let lc = false;
let uc = false;
let num = false;
let len = false;
let samePass = false;

$(document).ready(function () {
    registrationBtn = $("#registrationID");
    registrationBtn.attr('disabled','disabled');

    let myInput = document.getElementById("passwordRegistration");
    let letter = document.getElementById("letter");
    let capital = document.getElementById("capital");
    let number = document.getElementById("number");
    let length = document.getElementById("length");

    myInput.onkeyup = function() {
        comparePasswords();

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

function checkAllConditions(){
    if (lc && uc && num && len && samePass)registrationBtn.removeAttr("disabled");
    else registrationBtn.attr('disabled','disabled');
}