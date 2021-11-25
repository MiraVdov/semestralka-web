<?php

namespace app\Controllers;

use app\Models\ArticlesManagerModel as AM;
use app\Models\ReviewManagerModel as RM;
use app\Models\UserManagerModel as UMM;
use app\Utils\Helper;

class MyReviewsController implements IController
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
        $tplData["title"] = $pageTitle;
        $tplData["user"] = $this->um->getUserInfo();
        $tplData["userRight"] = $this->um->getUserRightInfo();

        if ($tplData["user"] != null){

            $tplData["assignedArticles"] = $this->articlesManager->getAllAssignedArticles($tplData["user"]["id_uzivatel"]);

            if (isset($_POST["action"]) && $_POST["action"] == "saveReview"){
               $this->reviewManager->updateReview($_POST["content"], $_POST["articleID"], $_POST["qualityValue"],$_POST["formalValue"], $_POST["newestValue"], $_POST["languageValue"], $tplData["user"]["id_uzivatel"]);
            }

            $index = 0;
            foreach ($tplData["assignedArticles"] as $article){
                $tplData["pdfs"][$index++] = base64_encode($article["pdf"]);
            }

            for ($i = 0; $i < sizeof($tplData["assignedArticles"]); $i++){
                $tplData["articles"][$i] = $this->reviewManager->getAllArticleReviews($tplData["assignedArticles"][$i]["id_clanku"]);
            }
            $tplData["alphabet"] =  array('A', 'B', 'C');
        }

        Helper::loginHelp($this->um);

        return $tplData;
    }
}