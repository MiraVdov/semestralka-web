<?php

namespace app\Controllers;

use app\Models\UserManagerModel as UMM;
use app\Utils\Helper;

/**
 * Trida zajistujici vypsani stranky s informacemi
 */
class InformationController implements IController
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
     * Metoda vraci text stranky informace
     * @param string $pageTitle - nazev stranky
     * @return array -text stranky
     */
    public function show(string $pageTitle): array
    {
        $tplData["title"] = $pageTitle;
        $tplData["user"] = $this->um->getUserInfo();//$this->db->getUserInfo();
        $tplData["userRight"] = $this->um->getUserRightInfo();//$this->db->getUserRightInfo();

        Helper::loginHelp($this->um);
        return $tplData;
    }
}