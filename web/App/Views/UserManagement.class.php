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
        $basicTemplate->getHeader();
        $basicTemplate->getFooter();
    }
}