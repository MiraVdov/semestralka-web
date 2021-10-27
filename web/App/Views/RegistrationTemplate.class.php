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
            $basicTemplate->getFooter();
        }
    }