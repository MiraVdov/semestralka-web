<?php

namespace app\Views;

/**
 * Sablona pro zobrazeni registrace
 */
class RegistrationTemplate implements IView
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
        if (array_key_exists("registrationVisible", $data)) echo $data["registrationVisible"];
        else $basicTemplate->getRegistrationForm();
        $basicTemplate->getFooter();
    }
}