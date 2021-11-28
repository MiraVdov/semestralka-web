function banUnbanUser(userID, action, index) {
    var result;

    if (action == "ban") result = confirm("Jste si jisti, že chcete daného uživatele zabanovat?");
    else result = confirm("Jste si jisti, že chcete daného uživatele odbanovat?");

    if (result == true) {
        $.post(
            "App/models/phpScripts/banUnbanUser-ajax.php",

            {
                "userID": userID,
                "action": action
            },

            // reakce na odpoved
            function (response, status) {

                if (status == "success") {
                    var user = "#user" + userID;
                    var columnWithButtons = "columnBanUnban"+userID;
                    var columnSelect = "#select"+index;

                    if (action == "ban"){
                        action = "unban";
                        document.getElementById(columnWithButtons).innerHTML = "<button type='button' class='btn btn-success' name='action' value='unban'" +
                            "onClick='banUnbanUser(" + userID + ", &#39;"+ action +"&#39;, "+index+")'>Povolit</button>";
                        $(user).addClass("bannedRow");
                        $(columnSelect).attr('disabled','disabled');
                    }else {
                        action = "ban";
                        document.getElementById(columnWithButtons).innerHTML = "<button type='button' class='btn btn-danger' name='action' value='ban'" +
                             "onClick='banUnbanUser("+ userID +", &#39;" + action + "&#39;, "+index+")'>Zakázat</button>";
                        $(user).removeClass("bannedRow");
                        $(columnSelect).removeAttr("disabled");
                    }

                    alert(response);

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
            "App/models/phpScripts/rightChange-ajax.php",

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