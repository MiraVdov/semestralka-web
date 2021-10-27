<?php

    namespace app;

    use app\Views\IView;
    use app\Controllers\IController;

    /**Start webove appky*/
    class ApplicationStart
    {
        /**
         * Metoda spoustici aplikaci
         */
        public function appStart(){
            if (isset($_GET["page"]) && array_key_exists($_GET["page"], WEB_PAGES))$pageTitle = $_GET["page"];
            else $pageTitle = DEFAULT_WEB_PAGE;

            // data stránky -array
            $pageInfo = WEB_PAGES[$pageTitle];

            //// nacteni odpovidajiciho kontroleru, jeho zavolani a vypsani vysledku
            // pripojim souboru ovladace
            //require_once(DIRECTORY_CONTROLLERS ."/". $pageInfo["file_name"]);

            // nactu ovladac a bez ohledu na prislusnou tridu ho typuju na dane rozhrani
            /** @var IController $controller  Ovladac prislusne stranky. */
            $controller = new $pageInfo["controller_class_name"];
            // zavolam prislusny ovladac a ziskam jeho obsah
            $tplData = $controller->show($pageInfo["title"]);

            /**@var IView $view sablona prislusne stranky*/
            $view = new $pageInfo[VIEW_CLASS_NAME];

            $view->printOut($tplData);
        }
    }