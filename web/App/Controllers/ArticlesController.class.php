<?php

namespace app\Controllers;

use app\Models\UserManagerModel as UMM;
use app\Models\ArticlesManagerModel as AM;
use app\Utils\Helper;

class ArticlesController implements IController
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
        $tplData["allArticles"] = $this->articlesManager->getAllArticles();

        if ($tplData["allArticles"] != null){
            // rozkodování clanku
            for ($i = 0; $i < sizeof($tplData["allArticles"]); $i++){
                $tplData["allArticles"][$i]["pdf"] = base64_encode($tplData["allArticles"][$i]["pdf"]);
            }
        }

        Helper::loginHelp($this->um);

        return $tplData;
    }
}