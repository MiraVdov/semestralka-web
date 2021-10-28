<?php

namespace app\Controllers;

use app\Models\DatabaseModel as DB;
use app\Utils\Helper;

/**
 * Trida zajistujici vypsani stranky se spravou uzivatelu
 */
class UserManagementController implements IController
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
     * @param string $pageTitle - nazev stranky
     * @return array - vytvorena data
     */
    public function show(string $pageTitle): array
    {
        $tplData = [];
        $tplData["title"] = $pageTitle;
        $tplData["users"] = $this->db->getAllUsers();

        Helper::loginHelp($this->db);
        $tplData["links"] = Helper::linkHelp($this->db);

        return $tplData;
    }
}