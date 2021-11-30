<?php

namespace app\Controllers;

use app\Models\UserManagerModel as UMM;
use app\Utils\Helper;

class ForgotPasswordController implements IController
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
     * Metoda vraci text stranky informace
     * @param string $pageTitle - nazev stranky
     * @return array -text stranky
     */
    public function show(string $pageTitle): array
    {
        $tplData["title"] = $pageTitle;
        $tplData["user"] = $this->um->getUserInfo();
        $tplData["userRight"] = $this->um->getUserRightInfo();

        if ($tplData["user"]== null){
            if (isset($_POST["action"]) && $_POST["action"] == "sendMail"){
                $user = null;
                if (($user = $this->um->getUserByEmail($_POST["mail"])) == []){
                    echo "<script>setTimeout(() => {alert('Uživatel se zadaným emailem u nás není registrován!') }, 200)</script>";
                }
                else {
                    if ($this->um->sendMail($_POST["mail"], $user[0]["id_uzivatel"])){
                        echo "<script>setTimeout(() => {alert('Odesláno!') }, 200)</script>";
                        header("Refresh:1; URL=index.php?page=resetPassword");
                    }
                    else{
                        echo "<script>setTimeout(() => {alert('Zadaná email neexistuje!') }, 200)</script>";
                    }

                }
            }
        }

        Helper::loginHelp($this->um);
        return $tplData;
    }
}