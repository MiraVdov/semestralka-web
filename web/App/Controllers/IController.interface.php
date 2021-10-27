<?php

    namespace app\Controllers;
    /**
     * Rozhrani pro ovladace
    */
    interface IController{
        /**
         * Metoda zajisti vypsani stranky
         * @param string $pageTitle - nazev stranky
         * @return array - vytvorena data pro sablonu
         */
        public function show(string $pageTitle):array;
    }