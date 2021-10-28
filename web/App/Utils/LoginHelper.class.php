<?php

namespace app\Utils;

use app\Models\DatabaseModel;

/**
 * Trida slouzi k praci s login formularem
 */
class LoginHelper
{
    /**
     * Metoda pomaha s prihlasenim uzivatele aby se kod ve tridach neopakoval
     * @param DatabaseModel $db - databazovej model
     */
    public static function loginHelp(DatabaseModel $db){
        // kliklo se na tlačítko přihlásit
        if (isset($_POST["action"]) && $_POST["action"] == "login"){
            // je vyplněen login a heslo
            if (isset($_POST["login"]) && trim($_POST["login"]) != "" &&
                isset($_POST["password"]) && trim($_POST["password"]) != ""){
                if ($db->isUserLogged()){
                    if($db->loginUser($_POST["login"], $_POST["password"])){
                        echo "Prihlasen " . $_SESSION["name"][2];
                    }
                    else{
                        echo "neprihlasen";
                    }
                }
            }
        }
    }
}