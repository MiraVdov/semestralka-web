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
            if (isset($_POST["action"]) ){
                if (isset($_POST["title"]) && $_POST["title"] != "" && $_POST["action"] == "createNewArticle"){
                    if (!empty($_FILES["pdf_file"]["name"]) && $_FILES["pdf_file"]["error"] == 0){
                        $this->articlesManager->createNewArticle($_POST["title"], strip_tags($_POST["abstract"]), $tplData["user"]["id_uzivatel"]);
                    }
                }
                elseif (isset($_POST["titleEdit"]) && $_POST["titleEdit"] != "" && $_POST["action"] == "editArticle"){
                    if (!empty($_FILES["pdf_file"]["name"]) && $_FILES["pdf_file"]["error"] == 0){
                        $this->articlesManager->editArticle($_POST["titleEdit"], strip_tags($_POST["abstractEdit"]), $_POST["id_articleEdit"]);
                    }
                }
            }

            $tplData["userArticles"] = $this->articlesManager->getAllUsersArticles($tplData["user"]["id_uzivatel"]);

            if ($tplData["userArticles"] != null){
                // rozkodování clanku
                for ($i = 0; $i < sizeof($tplData["userArticles"]); $i++){
                    $tplData["userArticles"][$i]["pdf"] = base64_encode($tplData["userArticles"][$i]["pdf"]);
                }
            }
        }
        Helper::loginHelp($this->um);
        return $tplData;
    }
}