<?php

namespace app\Controllers;

use app\Models\UserManagerModel as UMM;
use app\Utils\Helper;

/**
 * Trida zajistujici vypsani stranky se spravou uzivatelu
 */
class UserManagementController implements IController
{
    /**@var UMM $um instance modelu spravy uzivatelu*/
    private $um;

    /**
     * Vytvoreni instance pro komunikaci s databazi
     */
    public function __construct()
    {
        $this->um = new UMM();
    }

    /**
     * @param string $pageTitle - nazev stranky
     * @return array - vytvorena data
     */
    public function show(string $pageTitle): array
    {
        $tplData["title"] = $pageTitle;
        $tplData["allUsers"] = $this->um->getAllUsers();
        $tplData["user"] = $this->um->getUserInfo();
        $tplData["userRight"] = $this->um->getUserRightInfo();
        $tplData["allRights"] = $this->um->getAllRights();

        Helper::loginHelp($this->um);

        return $tplData;
    }
}