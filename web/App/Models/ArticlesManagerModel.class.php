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

    function getUsersArticles(){

    }

    public function getAllArticles(){
        return $this->databaseManager->selectFromTable(TABLE_ARTICLES);
    }
}