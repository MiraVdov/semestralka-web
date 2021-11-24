<?php

namespace app\Controllers;

use app\Models\ArticlesManagerModel as AM;
use app\Models\UserManagerModel;
use app\Models\UserManagerModel as UMM;
use app\Utils\Helper;

class ReviewsController implements IController
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
        $this->um = new UserManagerModel();
        $this->articlesManager = new AM();
    }

    /**
     * Metoda vraci data stranky programu
     * @param string $pageTitle - nazev stranky
     * @return array - data stranky
     */
    public function show(string $pageTitle): array
    {
        $tplData["title"] = $pageTitle;
        $tplData["user"] = $this->um->getUserInfo();
        $tplData["userRight"] = $this->um->getUserRightInfo();

        if ($tplData["user"] != null){
            if (isset($_POST["action"]) && $_POST["action"] == "addReviewer"){
                $this->articlesManager->createReview("", $_POST["articleID"], $_POST["reviewer"], 0, 0, 0, 0, 0);
            }

            $tplData["allArticles"] = $this->articlesManager->getAllArticles();

            for ($i = 0; $i < sizeof($tplData["allArticles"]); $i++){
                $tplData["articles"][$i] = $this->um->getAllPossibleReviewers($tplData["allArticles"][$i]["id_clanku"]);

                $tplData["articleReviews"][$i] = $this->articlesManager->getAllArticleReviews($tplData["allArticles"][$i]["id_clanku"]);
                $tplData["articleReviewers"][$i] = $this->um->getAllArticleReviewers($tplData["allArticles"][$i]["id_clanku"]);
            }



        }
        Helper::loginHelp($this->um);

        return $tplData;
    }
}
