<?php

namespace app\Models;

use app\Models\DatabaseManagerModel as DM;
use Cassandra\Date;

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


    function getAllArticleReviews(int $articleID){
        $whereStatement = "id_clanku = '$articleID'";
        return  $this->databaseManager->selectFromTable(TABLE_REVIEWS, $whereStatement);
    }

    function getAllAssignedArticles($userID){
        $orderBy = TABLE_ARTICLES .".datum ASC";
        $whereStatement = TABLE_REVIEWS .".id_recenzenta = $userID";
        $inner = TABLE_REVIEWS. " ON ". TABLE_ARTICLES . ".id_clanku = " . TABLE_REVIEWS . ".id_clanku";
        $m = TABLE_ARTICLES;
        $selection = "$m.id_clanku, $m.obsah, $m.datum, $m.id_uzivatel, $m.nadpis, $m.pdf, $m.id_stav";

        return $this->databaseManager->selectFromTable(TABLE_ARTICLES, $whereStatement, $orderBy, $selection,$inner);
    }


    /**
     * Metoda slouzi k vytvoreni recenze
     * @param string $content
     * @param int $articleID
     * @param int $reviewerID
     * @param int $reviewValue
     * @param int $contentValue
     * @param int $formalValue
     * @param int $newestValue
     * @param int $languageValue
     */
    function createReview(string $content, int $articleID, int $reviewerID, int $reviewValue, int $contentValue, int $formalValue, int $newestValue, int $languageValue){
        $date = date('Y-m-d H:i:s');
        $insertStatement = "datum, obsah, id_clanku, id_recenzenta, celkem, obsahBody, formalnost, novost, jazyk, zverejnena";
        $insertValues = "'$date', '$content', '$articleID', '$reviewerID', '$reviewValue', '$contentValue', '$formalValue', '$newestValue', '$languageValue', '0'";

        $this->databaseManager->insertIntoTable(TABLE_REVIEWS,$insertStatement, $insertValues);
    }

    /**
     * Metoda slouzi k aktualizaci recenze
     * @param string $content
     * @param int $articleID
     * @param int $reviewerID
     * @param int $reviewValue
     * @param int $contentValue
     * @param int $formalValue
     * @param int $newestValue
     * @param int $languageValue
     */
    function updateReview(string $content, int $articleID, int $reviewerID, int $reviewValue, int $contentValue, int $formalValue, int $newestValue, int $languageValue){
        $date = date('Y-m-d H:i:s');
        $insertStatementWithValues = "datum='$date', obsah='$content', celkem='$reviewValue', obsahBody='$contentValue', formalnost='$formalValue', novost='$newestValue', jazyk='$languageValue', zverejnena='1'";
        $whereStatement = "id_clanku='$articleID'";

        $this->databaseManager->updateInTable(TABLE_REVIEWS, $insertStatementWithValues, $whereStatement);

    }

    function deleteReview(){

    }
}