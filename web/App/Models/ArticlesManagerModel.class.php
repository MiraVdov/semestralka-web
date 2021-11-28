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
    public function getAllUsersArticles(int $userID): array{
        return $this->databaseManager->selectFromTable(TABLE_ARTICLES, "id_uzivatel=$userID", "datum DESC");
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

        $insertStatement = "obsah, datum, id_uzivatel, nadpis, pdf, id_stav";
        $insertValues = "'$content', '$date', '$userID', '$name', '$file', '3'";
        //$insertValues = ":content, '$date', '$userID', ':name', '$file', '3'";

        if ($_FILES["pdf_file"]["type"] != "application/pdf")return false;
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

        $this->databaseManager->deleteFromTable(TABLE_REVIEWS, "id_clanku = '$articleID'");
        $insertStatementWithValues = "obsah='$content', datum='$date', nadpis='$name', pdf='$file', id_stav= '3'";
        return $this->databaseManager->updateInTable(TABLE_ARTICLES, $insertStatementWithValues, "id_clanku='$articleID'");
    }

    /**
     * @param $userID
     * @return array
     */
    function getAllAssignedArticles($userID): array{
        $orderBy = TABLE_ARTICLES .".datum DESC";
        $whereStatement = TABLE_REVIEWS .".id_recenzenta = $userID";
        $inner = TABLE_REVIEWS. " ON ". TABLE_ARTICLES . ".id_clanku = " . TABLE_REVIEWS . ".id_clanku";
        $m = TABLE_ARTICLES;
        $selection = "$m.id_clanku, $m.obsah, $m.datum, $m.id_uzivatel, $m.nadpis, $m.pdf, $m.id_stav";

        return $this->databaseManager->selectFromTable(TABLE_ARTICLES, $whereStatement, $orderBy, $selection,$inner);
    }

    /**
     * @param int $articleID cislo clanku
     * @return bool true -zdarilo se, false - nikoliv
     */
    function deleteArticle(int $articleID): bool{
        $whereStatement = "id_clanku = '$articleID'";
        return $this->databaseManager->deleteFromTable(TABLE_ARTICLES, $whereStatement);
    }
}