<?php

namespace app\Controllers;

use app\Models\DatabaseManagerModel as DB;
use app\Utils\Helper;

/**
 * Trida zajistujici vypsani stranky s registraci
 */
class RegistrationController implements IController
{
    /**@var DB $db - instance modelu databaze*/
    private $db;

    /**
     * Vytvoreni instance pro komunikaci s databazi
     */
    public function __construct()
    {
        $this->db = DB::getDatabaseModel();
    }

    /**
     * Metoda vraci data stranky
     * @param string $pageTitle - nazev stranky
     * @return array - data stranky
     */
    public function show(string $pageTitle):array
    {
        $tplData["title"] = $pageTitle;
        $tplData["user"] = $this->db->getUserInfo();

        Helper::loginHelp($this->db);

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
                    $this->db->registerNewUser($_POST["username"], $_POST["fullName"], $_POST["telephone"], $_POST["email"], $_POST["password"]);
                }
                else{
                    $tplData["not_same_password"] = "hesla se neshoduji";
                }
            }
        }

        return $tplData;
    }
}