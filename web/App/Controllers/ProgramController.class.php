<?php

namespace app\Controllers;

use app\Models\DatabaseManagerModel as DB;
use app\Utils\Helper;

/**
 * Trida zajistujici vypsani stranky s programem
 */
class ProgramController implements IController
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
     * Metoda vraci data stranky programu
     * @param string $pageTitle - nazev stranky
     * @return array - data stranky
     */
    public function show(string $pageTitle): array
    {
        $tplData["title"] = $pageTitle;
        $tplData["user"] = $this->db->getUserInfo();
        $tplData["userRight"] = $this->db->getUserRightInfo();

        Helper::loginHelp($this->db);

        return $tplData;
    }
}