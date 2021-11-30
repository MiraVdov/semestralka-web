<?php

namespace app\Controllers;

use app\Models\UserManagerModel as UMM;
use app\Utils\Helper;

class ResetPasswordController implements IController
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

        if ($tplData["user"] == null){
            if (isset($_SESSION["ranData"]) && isset($_SESSION["userID"])){
                if (isset($_POST["action"]) &&  $_POST["action"] == "createNewPassword"){
                    if ($this->um->resetPassword($_SESSION["userID"], $_POST["password"])){
                        echo "<script>setTimeout(() => {alert('Heslo úspěšně změněno!') }, 200)</script>";
                        header("Refresh:1; URL=index.php?page=informations");
                    }
                }
            }
            else{
                echo "<script>setTimeout(() => {alert('Došlo k chybě!') }, 0)</script>";
                header("Refresh:0; URL=index.php?page=forgotPassword");
            }
            unset($_SESSION["ranData"]);
            unset($_SESSION["userID"]);
        }

        Helper::loginHelp($this->um);
        return $tplData;
    }


}
