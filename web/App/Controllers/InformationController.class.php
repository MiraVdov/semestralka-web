<?php

namespace app\Controllers;

use app\Models\DatabaseModel as DB;
use app\Utils\LoginHelper;

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

    public function show(string $pageTitle): array
    {
        LoginHelper::loginHelp($this->db);
        return array();
    }
}