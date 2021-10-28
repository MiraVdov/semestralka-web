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

        Helper::loginHelp($this->db);
        $userRight = $this->db->getUserRight();
        if ($userRight <= 2 && $this->db->isUserLogged()){
            $tplData["users"] = $this->db->getAllUsers();
            $tplData["table"] = $this->createTable($tplData);
        }else $tplData["table"] = "<h2 style='font-weight: bold'>Nemáte požadované právo na zobrazení této stránky!</h2>";

        $tplData["links"] = Helper::linkHelp($this->db);

        return $tplData;
    }

    /**
     * Metoda slouzi k vytvoreni tabulky ke sprave uzivatelu
     * @param array $data - data stranky
     */
    private function createTable(array $data){

        $output = "<div class='container'><h3>Správa uživatelů</h3><table class='table table-striped'>
        <thead><tr class='table-dark'><th>ID</th><th>S.</th><th>Login</th><th>Jméno</th><th>Role</th><th>Správa</th></tr></thead><tbody>";

        foreach ($data["users"] as $u){
            $output .= "<tr><td>$u[id_uzivatel]</td><td>$u[id_uzivatel]</td><td>$u[login]</td><td>$u[jmeno]</td><td>$u[jmeno]</td>"
                ."<td><form method='post'>"
                ."<input type='hidden' name='id_user' value='$u[id_uzivatel]'>"
                ."<button type='submit' name='action' value='delete'>Smazat</button>"
                ."</form></td></tr>";
        }
        $output .= "</tbody></table></div>";

        return $output;
    }
}