//funkce slouzi  zobrazeni loginu
$(document).ready(function () {
    // formátování datumu
    dateFormat();
});

// metoda slouží k formatovani datumu
function dateFormat(){
    const months = ["ledna", "února", "března", "dubna", "května", "června", "července", "srpna", "září", "října", "listopadu", "prosince"];

    var dateArray = document.getElementsByClassName("articlesHeader");
    var numberOfArticles = dateArray.length;
    var date;
    for (let i = 0; i < numberOfArticles; i++) {
        date = new Date(dateArray[i].innerHTML);
        var minutes = date.getMinutes();
        var hours = date.getHours();
        if (minutes < 10) minutes = "0" + minutes;
        if (hours < 10) hours = "0" + hours;
        dateArray[i].innerHTML = date.getDate() + ". " + months[date.getMonth()] + " " + date.getFullYear() + " " + hours + ":" + minutes;
        dateArray[i].style.fontSize = "12px";
    }
}