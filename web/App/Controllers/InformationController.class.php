<?php

namespace app\Controllers;

use app\Models\DatabaseManagerModel as DB;
use app\Utils\Helper;

/**
 * Trida zajistujici vypsani stranky s informacemi
 */
class InformationController implements IController
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
     * Metoda vraci text stranky informace
     * @param string $pageTitle - nazev stranky
     * @return array -text stranky
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