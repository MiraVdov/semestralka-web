<?php

namespace app\Models;

use app\Models\DatabaseManagerModel as DM;

/**
 * Třída sloužící ke správě recenzí
 */
class ReviewManagerModel
{
    private $databaseManager;

    function __construct()
    {
        $this->databaseManager = DM::getDatabaseModel();
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
     * @return bool
     */
    function createReview(string $content, int $articleID, int $reviewerID, int $reviewValue, int $contentValue, int $formalValue, int $newestValue, int $languageValue){
        $date = date('Y-m-d H:i:s');
        $insertStatement = "datum, obsah, id_clanku, id_recenzenta, celkem, obsahBody, formalnost, novost, jazyk, zverejnena";
        $insertValues = "'$date', '$content', '$articleID', '$reviewerID', '$reviewValue', '$contentValue', '$formalValue', '$newestValue', '$languageValue', '0'";

        return $this->databaseManager->insertIntoTable(TABLE_REVIEWS,$insertStatement, $insertValues);
    }

    /**
     * Metoda slouzi k aktualizaci recenze
     * @param string $content
     * @param int $articleID
     * @param int $contentValue
     * @param int $formalValue
     * @param int $newestValue
     * @param int $languageValue
     * @param int $userID
     * @return bool
     */
    function updateReview(string $content, int $articleID, int $contentValue, int $formalValue, int $newestValue, int $languageValue, int $userID){
        $date = date('Y-m-d H:i:s');
        $reviewValue = ($contentValue + $formalValue + $newestValue + $languageValue)/4;

        $insertStatementWithValues = "datum='$date', obsah='$content', celkem='$reviewValue', obsahBody='$contentValue', formalnost='$formalValue', novost='$newestValue', jazyk='$languageValue', zverejnena='1'";
        $whereStatement = "id_clanku='$articleID' AND id_recenzenta = '$userID'";

        return $this->databaseManager->updateInTable(TABLE_REVIEWS, $insertStatementWithValues, $whereStatement);
    }

    /**
     * @param $articleID
     */
    function acceptArticle($articleID){
        $insertStatementWithValue = "id_stav = '2'";
        $whereStatement = "id_clanku = '$articleID'";

        $this->databaseManager->updateInTable(TABLE_ARTICLES, $insertStatementWithValue, $whereStatement);
    }

    /**
     * @param $articleID
     */
    function rejectArticle($articleID){
        $insertStatementWithValue = "id_stav = '1'";
        $whereStatement = "id_clanku = '$articleID'";

        $this->databaseManager->updateInTable(TABLE_ARTICLES, $insertStatementWithValue, $whereStatement);
    }

    /**
     * @param int $articleID
     * @return array
     */
    function getAllArticleReviews(int $articleID): array{
        $whereStatement = "id_clanku = '$articleID'";
        return  $this->databaseManager->selectFromTable(TABLE_REVIEWS, $whereStatement);
    }



    function deleteReview(int $aticleID){
        $whereStatement = "id";
        //$this->databaseManager->deleteFromTable(TABLE_REVIEWS);
    }
}