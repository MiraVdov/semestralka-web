<?php

namespace app\Views;

/**
 * Sablona pro zobrazeni spravy uzivatelu
 */
class UserManagement implements IView
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

    private function createTable(array $data){

        $output = "<div class='container'><h3>Správa uživatelů</h3><table class='table  table-striped'>
        <thead><tr><th>Firstname</th><th>Lastname</th><th>Email</th><th>Sprava</th></tr></thead><tbody>";

        foreach ($data["users"] as $u){
            $output .= "<tr><td>$u[jmeno]</td><td>$u[jmeno]</td><td>$u[email]</td>"
            ."<td><form method='post'>"
                ."<input type='hidden' name='id_user' value='$u[id_uzivatel]'>"
                ."<button type='submit' name='action' value='delete'>Smazat</button>"
                ."</form></td></tr>";
        }
        $output .= "</tbody></table></div>";

        echo $output;
    }
}