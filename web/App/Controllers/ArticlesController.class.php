<?php

namespace app\Controllers;

use app\Models\UserManagerModel as UMM;
use app\Models\ArticlesManagerModel as AM;
use app\Models\ReviewManagerModel as RM;
use app\Utils\Helper;

class ArticlesController implements IController
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
        $tplData["allArticles"] = $this->articlesManager->getAllArticles();

        if (count($tplData["allArticles"]) > 0){
            // rozkodování clanku
            for ($i = 0; $i < sizeof($tplData["allArticles"]); $i++){
                $tplData["allArticles"][$i]["pdf"] = base64_encode($tplData["allArticles"][$i]["pdf"]);
            }

            for ($i = 0; $i < sizeof($tplData["allArticles"]); $i++){
                $tplData["articles"][$i] = $this->reviewManager->getAllArticleReviews($tplData["allArticles"][$i]["id_clanku"]);
            }
            $tplData["alphabet"] =  array('A', 'B', 'C');
        }

        return $tplData;
    }
}