<?php

namespace app\Controllers;

use app\Models\DatabaseModel;

/**
 * Trida zajistujici vypsani stranky se spravou uzivatelu
 */
class UserManagerController implements IController
{
    /**@var DatabaseModel - instance modelu databaze*/
    private $db;

    /**
     * Vytvoreni instance pro komunikaci s databazi
     */
    public function __construct()
    {
        $this->db::getDatabaseModel();
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

        return $tplData;
    }
}