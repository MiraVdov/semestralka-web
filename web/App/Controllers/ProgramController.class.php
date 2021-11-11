<?php

namespace app\Controllers;

use app\Models\UserManagerModel;
use app\Models\UserManagerModel as UMM;
use app\Utils\Helper;

/**
 * Trida zajistujici vypsani stranky s programem
 */
class ProgramController implements IController
{
    /**@var UMM $um instance modelu spravy uzivatelu*/
    private $um;

    /**
     * Vytvoreni instance pro komunikaci s databazi
     */
    public function __construct()
    {
        $this->um = new UserManagerModel();
    }

    /**
     * Metoda vraci data stranky programu
     * @param string $pageTitle - nazev stranky
     * @return array - data stranky
     */
    public function show(string $pageTitle): array
    {
        $tplData["title"] = $pageTitle;
        $tplData["user"] = $this->um->getUserInfo();
        $tplData["userRight"] = $this->um->getUserRightInfo();

        Helper::loginHelp($this->um);

        return $tplData;
    }
}