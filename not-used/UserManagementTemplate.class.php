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
        echo $data["links"];
        $basicTemplate->getLoginForm();
        echo $data["table"];
        $basicTemplate->getFooter();
    }
}