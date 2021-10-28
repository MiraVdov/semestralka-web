<?php

namespace app\Views;

/**
 * Sablona pro zobrazeni spravy uzivatelu
 */
class UserManagementTemplate implements IView
{
    /**
     * Metoda vypise sablonu
     * @param array $data - data stranky
     */
    public function printOut(array $data)
    {
        $basicTemplate = new BasicTemplate();
        $basicTemplate->getHeader("a");
        $this->createTable($data);
        $basicTemplate->getFooter();
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

        echo $output;
    }
}