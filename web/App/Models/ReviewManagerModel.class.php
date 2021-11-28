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
     * @return bool
     */
    function createReview(string $content, int $articleID, int $reviewerID): bool{
        $date = date('Y-m-d H:i:s');
        $content = htmlspecialchars($content);
        $articleID = htmlspecialchars($articleID);
        $reviewerID = htmlspecialchars($reviewerID);

        return $this->databaseManager->createReview($date, $content, $articleID, $reviewerID);
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
    function updateReview(string $content, int $articleID, int $contentValue, int $formalValue, int $newestValue, int $languageValue, int $userID): bool{
        $date = date('Y-m-d H:i:s');
        $content = htmlspecialchars($content);
        $articleID = htmlspecialchars($articleID);
        $contentValue = htmlspecialchars($contentValue);
        $formalValue = htmlspecialchars($formalValue);
        $newestValue = htmlspecialchars($newestValue);
        $languageValue = htmlspecialchars($languageValue);
        $userID = htmlspecialchars($userID);
        $reviewValue = (intval($contentValue) + intval($formalValue) + intval($newestValue) + intval($languageValue))/4;

        return $this->databaseManager->updateReview($content, $articleID, $contentValue, $formalValue, $newestValue, $languageValue, $userID, $date, $reviewValue);
    }

    /**
     * @param $articleID
     */
    function acceptArticle($articleID){
        $articleID = htmlspecialchars($articleID);
        $this->databaseManager->updateArticleStatus($articleID, 2);
    }

    /**
     * @param $articleID
     */
    function rejectArticle($articleID){
        $articleID = htmlspecialchars($articleID);
        $this->databaseManager->updateArticleStatus($articleID, 1);
    }

    /**
     * @param int $articleID
     * @return array
     */
    function getAllArticleReviews(int $articleID): array{
        $articleID = htmlspecialchars($articleID);
        return $this->databaseManager->getAllArticleReviews($articleID);
    }
}