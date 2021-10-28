<?php

namespace app\Controllers;

use app\Models\DatabaseModel as DB;
use app\Utils\Helper;

/**
 * Trida zajistujici zobrazeni stranky s vlastnimi clanky
 */
class MyArticlesController implements IController
{
    /**@var DB $db - instance modelu databaze*/
    private $db;

    /**
     * Vytvoreni instance pro komunikaci s databazi
     */
    public function __construct()
    {
        $this->db = DB::getDatabaseModel();
    }

    /**
     * Metoda vraci telo stranky
     * @param string $pageTitle - nazev stranky
     * @return array -data stranky
     */
    public function show(string $pageTitle): array
    {
        Helper::loginHelp($this->db);
        $tplData["links"] = Helper::linkHelp($this->db);

        $tplData["addNewArticleButton"] = "<button type='button' class='btn btn-success'>Success</button>";

        return $tplData;
    }
}