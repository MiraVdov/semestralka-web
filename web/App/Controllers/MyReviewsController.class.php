<?php

namespace app\Controllers;

use app\Models\ArticlesManagerModel as AM;
use app\Models\UserManagerModel as UMM;
use app\Utils\Helper;

class MyReviewsController implements IController
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

        if ($tplData["user"] != null){
            //$tplData["allArticles"] = $this->articlesManager->getAllArticles();

            $tplData["assignedArticles"] = $this->articlesManager->getAllAssignedArticles($tplData["user"]["id_uzivatel"]);
            //print_r($tplData["assignedArticles"]);

            if (isset($_POST["action"]) && $_POST["action"] == "saveReview"){

            }
            $index = 0;
            foreach ($tplData["assignedArticles"] as $article){
                $tplData["pdfs"][$index++] = base64_encode($article["pdf"]);
            }

            $data = $tplData["pdfs"][0];

        }

        Helper::loginHelp($this->um);

        return $tplData;
    }
}