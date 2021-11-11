<?php

namespace app\Models;

use app\Models\DatabaseManagerModel as DM;

class ArticlesManagerModel
{
    private $databaseManager;

    function __construct()
    {
        $this->databaseManager = DM::getDatabaseModel();
    }


    public function getAllArticles(){
        return $this->databaseManager->selectFromTable(TABLE_ARTICLES);
    }

    public function getAllUsersArticles(int $userID){

        return $this->databaseManager->selectFromTable(TABLE_ARTICLES, "id_uzivatel=$userID");
    }
}