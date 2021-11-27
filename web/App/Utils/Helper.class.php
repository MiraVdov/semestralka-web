<?php

namespace app\Utils;

use app\Models\UserManagerModel;

/**
 * Trida slouzi k zkraceni opakovani kodu pro login form a odkzay
 */
class Helper
{
    /**
     * Metoda pomaha s prihlasenim uzivatele aby se kod ve tridach neopakoval (da se prihlasit z jakekoliv stranky)
     * @param UserManagerModel $um - databazovy model
     */
    public static function loginHelp(UserManagerModel $um){
        // kliklo se na tlačítko přihlásit
        if (isset($_POST["action"]) && $_POST["action"] == "login"){
            // je vyplněen login a heslo
            if (isset($_POST["login"]) && trim($_POST["login"]) != "" &&
                isset($_POST["password"]) && trim($_POST["password"]) != ""){
                if (!$um->isUserLogged()){
                    if($um->loginUser($_POST["login"], $_POST["password"])){
                        echo "<script>setTimeout(() => {alert('Uživatel úspěšně přihlášen!') }, 200)</script>";
                    }
                    else{
                        if (isset($GLOBALS["isBanned"])) echo "<script>setTimeout(() => {alert('Uživatele nebylo možné přihlásit, protože byl zabanován!') }, 200)</script>";
                        else echo "<script>setTimeout(() => {alert('Zadány špatné přihlašovací údaje!') }, 200)</script>";
                    }
                    header('Refresh: 0.5');
                }
            }
        }
        //// bylo zmacknuto tlacitko odhlaseni
        else if(isset($_POST["action"]) && $_POST["action"] == "logout"){
            $um->logoutUser();
            // vypsání alertu
            echo "<script>setTimeout(() => {alert('Uživatel úspěšně odhlášen!') }, 200)</script>";
            // refresh stranky
            header('Refresh: 0.5');
        }
    }
}