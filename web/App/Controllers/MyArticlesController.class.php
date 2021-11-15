<?php

namespace app\Controllers;

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

    /**
     * Vytvoreni instance pro komunikaci s databazi
     */
    public function __construct()
    {
        $this->um = new UMM();
        $this->articlesManager = new AM();
    }

    /**
     * Metoda vraci telo stranky
     * @param string $pageTitle - nazev stranky
     * @return array -data stranky
     */
    public function show(string $pageTitle): array
    {
        $tplData["title"] = $pageTitle;
        $tplData["user"] = $this->um->getUserInfo();
        $tplData["userRight"] = $this->um->getUserRightInfo();
        // pokud mám uživatele tak si uložím všechny jeho články
        if ($tplData["user"] != null){

            // vytvořenínového článku
            if (isset($_POST["action"]) && $_POST["action"] == "createNewArticle"){
                if ($_POST["title"] != ""){
                    if (!empty($_FILES["pdf_file"]["name"]) && $_FILES["pdf_file"]["error"] == 0){
                        $this->articlesManager->createNewArticle($_POST["title"], "asdsad", $tplData["user"]["id_uzivatel"]);
                    }
                }
            }

            $tplData["userArticles"] = $this->articlesManager->getAllUsersArticles($tplData["user"]["id_uzivatel"]);
        }

        // rozkodování clanku
        for ($i = 0; $i < sizeof($tplData["userArticles"]); $i++){
            $tplData["userArticles"][$i]["pdf"] = base64_encode($tplData["userArticles"][$i]["pdf"]);
        }

        Helper::loginHelp($this->um);
        return $tplData;
    }
}