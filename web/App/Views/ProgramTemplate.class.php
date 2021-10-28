<?php

    namespace app\Views;

    /**
     * Sablona pro program
     */
    class ProgramTemplate implements IView
    {
        /**
         * Metoda vypise sablonu pro program
         * @param array $data - data stranky
         */
        public function printOut(array $data)
        {
            $basicTemplate = new BasicTemplate();
            $basicTemplate->getHeader("hello");
            echo $data["links"];
            $basicTemplate->getLoginForm();
            $basicTemplate->getProgramLorem();
            $basicTemplate->getFooter();
        }
    }