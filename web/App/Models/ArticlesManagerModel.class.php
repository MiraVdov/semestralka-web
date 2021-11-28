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
    public function getAllArticles(): array{
        return $this->databaseManager->selectFromTable(TABLE_ARTICLES, "", "datum DESC");
    }

    /**
     * Metoda vraci všechny články uživatele
     * @param int $userID
     * @return array
     */
    public function getAllUsersArticles(int $userID): array{
        $userID = htmlspecialchars($userID);
        return $this->databaseManager->getAllUsersArticles($userID);
    }

    /**
     * @param string $name
     * @param string $content
     * @param int $userID
     * @return bool
     */
    public function createNewArticle(string $name, string $content, int $userID):bool{
        $name = htmlspecialchars($name);
        $content = htmlspecialchars($content);
        $date = date('Y-m-d H:i:s');
        $file_tmp = $_FILES['pdf_file']['tmp_name']; // cesta k souboru
        $file = addslashes(file_get_contents($file_tmp));

        if ($_FILES["pdf_file"]["type"] != "application/pdf")return false;

        return $this->databaseManager->insertNewArticle($content, $date, $userID, $name, $file);
    }

    /**
     * Metoda slouží k upravě článku
     * @param string $name
     * @param string $content
     * @param int $articleID
     * @return bool zda se povedlo
     */
    public function editArticle(string $name, string $content, int $articleID): bool{
        $date = date('Y-m-d H:i:s');
        $file_tmp = $_FILES['pdf_file']['tmp_name']; // cesta k souboru
        $file = addslashes(file_get_contents($file_tmp));
        $name = htmlspecialchars($name);
        $content = htmlspecialchars($content);

        if ($_FILES["pdf_file"]["type"] != "application/pdf")return false;

        $this->databaseManager->deleteArticleReviews($articleID);
        return $this->databaseManager->updateArticle($content, $date, $name, $file, $articleID);
    }

    /**
     * @param $userID
     * @return array
     */
    function getAllAssignedArticles($userID): array{
        $userID = htmlspecialchars($userID);
        return $this->databaseManager->getAllAssignedArticles($userID);
    }

    /**
     * @param int $articleID cislo clanku
     * @return bool true -zdarilo se, false - nikoliv
     */
    function deleteArticle(int $articleID): bool{
        $articleID = htmlspecialchars($articleID);
        return $this->databaseManager->deleteArticle($articleID);
    }
}