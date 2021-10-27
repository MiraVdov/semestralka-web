<?php

    namespace app\Views;

    class InformationTemplate implements IView
    {
        /**
         * Metoda vypise sablonu
         * @param array $data - data stranky
         */
        public function printOut(array $data)
        {
            $basicTemplate = new BasicTemplate();
            $basicTemplate->getHeader("hello");
            $basicTemplate->getAlertBoxes();
            $basicTemplate->getInformationLorem();
            $basicTemplate->getFooter();
        }
    }