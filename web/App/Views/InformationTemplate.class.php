<?php

    namespace app\Views;

    class InformationTemplate implements IView
    {
        /**
         * @param array $data - Metoda vypíše
         */
        public function printOut(array $data)
        {
            BasicTemplate::getHeader("a");
        }
    }