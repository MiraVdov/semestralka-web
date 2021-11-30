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
        $tplData["checkCode"] = null;

        if ($tplData["user"]== null){
            if (isset($_POST["action"])){
                if ($_POST["action"] == "sendMail"){
                    $user = null;
                    if (($user = $this->um->getUserByEmail($_POST["mail"])) == []){
                        echo "<script>setTimeout(() => {alert('Uživatel se zadaným emailem u nás není registrován!') }, 200)</script>";
                    }
                    else {
                        if ($this->um->sendMail($_POST["mail"], $user[0]["id_uzivatel"])){
                            echo "<script>setTimeout(() => {alert('Odesláno!') }, 200)</script>";
                            $tplData["checkCode"] = 1;
                        }
                        else{
                            echo "<script>setTimeout(() => {alert('Zadaná email neexistuje!') }, 200)</script>";
                        }
                    }
                }
                else if($_POST["action"] == "validation"){
                    $data = $_SESSION["ranData"];
                    if ($_POST["num1"] == $data[0] && $_POST["num2"] == $data[1] && $_POST["num3"] == $data[2] && $_POST["num4"] == $data[3]){
                        echo "<script>setTimeout(() => {alert('Správný kód!') }, 200)</script>";
                        unset($_SESSION["ranData"]);
                        header("Refresh:1; URL=index.php?page=resetPassword");
                    }else{
                        echo "<script>setTimeout(() => {alert('Špatný kód!') }, 200)</script>";
                        header("Refresh:1; URL=index.php?page=forgotPassword");
                    }
                }
            }
        }

        Helper::loginHelp($this->um);
        return $tplData;
    }
}