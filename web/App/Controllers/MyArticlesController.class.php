<?php

namespace app\Controllers;

use app\Models\ReviewManagerModel as RM;
use app\Models\UserManagerModel as UMM;
use app\Models\ArticlesManagerModel as AM;
use app\Utils\Helper;

/**
 * Trida zajistujici zobrazeni stranky s vlastnimi clanky
 */
class MyArticlesController implements IController
{
    /**@var UMM $um instance modelu spravy uzivatelu*/
    private $um;
    /**@var AM $articlesManager instance modelu spravy clanku*/
    private $articlesManager;

    /**@var RM $reviewManager instance modelu spravy recenzi*/
    private $reviewManager;

    /**
     * Vytvoreni instance pro komunikaci s databazi
     */
    public function __construct()
    {
        $this->um = new UMM();
        $this->articlesManager = new AM();
        $this->reviewManager = new RM();
    }

    /**
     * Metoda vraci telo stranky
     * @param string $pageTitle - nazev stranky
     * @return array -data stranky
     */
    public function show(string $pageTitle): array
    {
        Helper::loginHelp($this->um);

        $tplData["title"] = $pageTitle;
        $tplData["user"] = $this->um->getUserInfo();
        $tplData["userRight"] = $this->um->getUserRightInfo();
        // pokud mám uživatele tak si uložím všechny jeho články
        if ($tplData["user"] != null){

            // vytvořenínového článku
            if (isset($_POST["action"]) ){
                if (isset($_POST["title"]) && $_POST["title"] != "" && $_POST["action"] == "createNewArticle"){
                    if (!empty($_FILES["pdf_file"]["name"]) && $_FILES["pdf_file"]["error"] == 0){
                        if (!$this->articlesManager->createNewArticle($_POST["title"], strip_tags($_POST["abstract"]), $tplData["user"]["id_uzivatel"])){
                            echo "<script>setTimeout(() => {alert('Soubor není pdf!') }, 200)</script>";
                        }else echo "<script>setTimeout(() => {alert('Článek vytvořen.') }, 200)</script>";
                    }
                } // upravení existujícího článku
                elseif (isset($_POST["titleEdit"]) && $_POST["titleEdit"] != "" && $_POST["action"] == "editArticle"){
                    if (!empty($_FILES["pdf_file"]["name"]) && $_FILES["pdf_file"]["error"] == 0){
                        $this->articlesManager->editArticle($_POST["titleEdit"], strip_tags($_POST["abstractEdit"]), $_POST["id_articleEdit"]);
                    }
                }
            }

            $tplData["userArticles"] = $this->articlesManager->getAllUsersArticles($tplData["user"]["id_uzivatel"]);
                // rozkodování clanku
            for ($i = 0; $i < sizeof($tplData["userArticles"]); $i++){
                $tplData["userArticles"][$i]["pdf"] = base64_encode($tplData["userArticles"][$i]["pdf"]);
            }

            for ($i = 0; $i < sizeof($tplData["userArticles"]); $i++){
                $tplData["articles"][$i] = $this->reviewManager->getAllArticleReviews($tplData["userArticles"][$i]["id_clanku"]);
            }
            $tplData["alphabet"] =  array('A', 'B', 'C');
        }

        return $tplData;
    }
}