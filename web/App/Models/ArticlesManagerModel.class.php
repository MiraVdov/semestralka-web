<?php

namespace app\Models;

use app\Models\DatabaseManagerModel as DM;

/**
 * Třída sloužící ke správě článků
 */
class ArticlesManagerModel
{
    private $databaseManager;

    function __construct()
    {
        $this->databaseManager = DM::getDatabaseModel();
    }

    /**
     * Metoda vrací všechny články
     * @return array
     */
    public function getAllArticles(){
        return $this->databaseManager->selectFromTable(TABLE_ARTICLES, "", "datum DESC");
    }

    /**
     * Metoda vraci všechny články uživatele
     * @param int $userID
     * @return array
     */
    public function getAllUsersArticles(int $userID){

        return $this->databaseManager->selectFromTable(TABLE_ARTICLES, "id_uzivatel=$userID", "datum DESC");
    }

    /**
     * @param string $name
     * @param string $content
     * @param int $userID
     * @return bool
     */
    public function createNewArticle(string $name, string $content, int $userID){
        $date = date('Y-m-d H:i:s');

        $file_tmp = $_FILES['pdf_file']['tmp_name']; // cesta k souboru
        $file = addslashes(file_get_contents($file_tmp));

        $insertStatement = "obsah, datum, id_uzivatel, nadpis, pdf";
        $insertValues = "'$content', '$date','$userID', '$name', '$file'";
        return $this->databaseManager->insertIntoTable(TABLE_ARTICLES, $insertStatement, $insertValues);
    }

    /**
     * Metoda slouží k upravě článku
     * @param string $name
     * @param string $content
     * @param int $articleID
     * @return bool zda se povedlo
     */
    public function editArticle(string $name, string $content, int $articleID){
        $date = date('Y-m-d H:i:s');

        $file_tmp = $_FILES['pdf_file']['tmp_name']; // cesta k souboru
        $file = addslashes(file_get_contents($file_tmp));

        $insertStatementWithValues = "obsah='$content', datum='$date', nadpis='$name', pdf='$file'";
        return $this->databaseManager->updateInTable(TABLE_ARTICLES, $insertStatementWithValues, "id_clanku='$articleID'");
    }

    /**
     * Metoda vraci pro dany clanek všechny dostpune recenzenty. (ps ty kteří ještě daný článek nerecenzovali)
     * @param int $articleID
     * @return array
     */
    function getAllPossibleReviewers(int $articleID){
        $whereStatement = "id_clanku = '$articleID'";
        $usedReviewers = array();
        $reviews = $this->databaseManager->selectFromTable(TABLE_REVIEWS, $whereStatement);

        for ($i = 0; $i < sizeof($reviews); $i++){
            $usedReviewers[$i] = $reviews[$i]["id_recenzenta"];
        }

        $allReviewers = $this->databaseManager->selectFromTable(TABLE_USER, "id_pravo = 3");
        $g =sizeof($allReviewers);
        for ($i = 0; $i < $g; $i++) {
            for ($j = 0; $j < sizeof($usedReviewers); $j++) {
                if ($allReviewers[$i]["id_uzivatel"] == $usedReviewers[$j]){
                    unset($allReviewers[$i]);
                    break;
                }
            }
        }

        return $allReviewers;
    }

    function getAllArticleReviews(int $articleID){
        $whereStatement = "id_clanku = '$articleID'";
        return  $this->databaseManager->selectFromTable(TABLE_REVIEWS, $whereStatement);
    }

    /**
     * Metoda vraci vsechny recenzenty daneho clanku clanku
     * @param int $articleID
     * @return array
     */
    function getAllArticleReviewers(int $articleID){
        $whereStatement = "id_clanku = '$articleID'";
        $reviews = $this->databaseManager->selectFromTable(TABLE_REVIEWS, $whereStatement);
        $articleReviewers = array();
        $index = 0;

        foreach ($reviews as $review){
            $usedID = $review["id_recenzenta"];
            $user = $this->databaseManager->selectFromTable(TABLE_USER, "id_uzivatel = '$usedID'");
            $articleReviewers[$index++] = $user[0];
        }

        return $articleReviewers;
    }

    function getAllAssignedArticles($userID){
        $articles = $this->databaseManager->selectFromTable(TABLE_REVIEWS, "id_recenzenta = '$userID'");
        $articlesID = array();

        for($i = 0; $i < sizeof($articles); $i++){
            $articlesID[$i] = $articles[$i]["id_clanku"];
        }

        $whereStatement = "id_clanku = ";
        for($i = 0; $i < sizeof($articlesID); $i++){
            if ($i == sizeof($articlesID) - 1){
                $whereStatement .= "'$articlesID[$i]'";
            }else{
                $whereStatement .= "'$articlesID[$i]' OR id_clanku = ";
            }
        }

        return $this->databaseManager->selectFromTable(TABLE_ARTICLES, $whereStatement);
    }
}