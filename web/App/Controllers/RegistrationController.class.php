<?php

namespace app\Controllers;

use app\Models\UserManagerModel as UMM;
use app\Utils\Helper;

/**
 * Trida zajistujici vypsani stranky s registraci
 */
class RegistrationController implements IController
{
    /**@var UMM $um instance modelu spravy uzivatelu*/
    private $um;

    /**
     * Vytvoreni instance pro komunikaci s databazi
     */
    public function __construct()
    {
        $this->um = new UMM();
    }

    /**
     * Metoda vraci data stranky
     * @param string $pageTitle - nazev stranky
     * @return array - data stranky
     */
    public function show(string $pageTitle):array
    {
        $tplData["title"] = $pageTitle;
        $tplData["user"] = $this->um->getUserInfo();

        Helper::loginHelp($this->um);

        // bylo zmáčknuté tlačítko
        if (isset($_POST["action"]) && $_POST["action"] == "registration"){
            // jsou vyplnena pole (kromě hesla)
            if (isset($_POST["username"]) && trim($_POST["username"]) != "" &&
            isset($_POST["fullName"]) && trim($_POST["fullName"]) != "" &&
            isset($_POST["telephone"]) &&
            isset($_POST["email"]) && trim($_POST["email"]) != ""){
                // jsou vyplnena hesla a shoduji se
                if (isset($_POST["password"]) && $_POST["password"] != "" &&
                isset($_POST["password2"]) && $_POST["password2"] != "" &&
                $_POST["password"] == $_POST["password2"]){
                    if($this->um->registerNewUser($_POST["username"], $_POST["fullName"], $_POST["telephone"], $_POST["email"], $_POST["password"])) {
                        echo "<script>setTimeout(() => {alert('Uživatel úspěšně zaregistrován!') }, 200)</script>";
                        header('Refresh: 0.5');
                    }
                }
                else{
                    echo "<script>setTimeout(() => {alert('Hesla se neshodují nebo jsou prázdná!') }, 200)</script>";
                    header('Refresh: 0.5');
                }
            }
        }

        return $tplData;
    }
}