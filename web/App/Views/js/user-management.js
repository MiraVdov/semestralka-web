function banUnbanUser(userID, action) {
    var result = confirm("Jste si jisti, že chcete daného uživatele zabanovat?");
    if (result == true) {
        $.post(
            "App/models/banUnbanUser-ajax.php",

            {
                "userID": userID,
                "action": action
            },

            // reakce na odpoved
            function (response, status) {

                if (status == "success") {
                    alert("Uživatel zabanován");
                } else if (status == "error") {
                    alert("Došlo k chybě!");
                }
            }
        );
    }
}


var previousSelectValue;
function previousValue(index){
    var select = "#select"+index;
    previousSelectValue = $(select + " option:selected").val();
}

function changeRight(index, userID){
    var select = "#select"+index;
    var option = $(select + " option:selected");
    var rightID = option.val();

    var result = confirm("Jste si jisti, že chcete danému uživateli změnit roli?");
    if (result == true){
        $.post(
            "App/models/rightChange-ajax.php",

            {
                "userID" : userID,
                "rightID" : rightID
            },

            // reakce na odpoved
            function(response, status) {
                // je dopoved v poradku?
                if( status == "success" ){
                    alert("Role úspěšně změněna!");
                }
                // je odpoved error?
                else if( status == "error" ){
                    alert("Došlo k chybě!");
                }
            }
        );
    }
    else{
        $(select + ' option').removeAttr('selected')
            .filter('[value=' + previousSelectValue +']')
            .attr('selected', true)
    }
}