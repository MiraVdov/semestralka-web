<?php

    namespace app;

    use web\app\Views\IView;
    use web\app\Controllers\IController;

    /**Start webove appky*/
    class ApplicationStart
    {
        /**
         * Metoda spoustici aplikaci
         */
        public function appStart(){
            if (isset($_GET["page"]) && array_key_exists($_GET["page"], WEB_PAGES))$pageKey = $_GET["page"];
            else $pageKey = DEFAULT_WEB_PAGE;

            // data stránky
            $pageInfo = WEB_PAGES[$pageKey];

            $view = new $pageInfo["view_class_name"];
            $view->printOut(array(1,2,3));
        }
    }