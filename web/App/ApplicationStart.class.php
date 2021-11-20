<?php

namespace app;

use app\Controllers\IController;

/**Start webove appky*/
class ApplicationStart
{
    /**
     * Metoda spoustici aplikaci
     */
    public function appStart()
    {
        if (isset($_GET["page"]) && array_key_exists($_GET["page"], WEB_PAGES)) $pageTitle = $_GET["page"];
        else $pageTitle = DEFAULT_WEB_PAGE;

        // data stránky -array
        $pageInfo = WEB_PAGES[$pageTitle];

        /** @var IController $controller Ovladac prislusne stranky.*/
        $controller = new $pageInfo["controller_class_name"];

        // data šablony od kontroleru
        $tplData = $controller->show($pageInfo["title"]);

        $view = $pageInfo["view_name"];
        require_once 'libraries/composer/vendor/autoload.php';
        $templatesDirectory = 'App/Views/twig';
        $loader = new \Twig\Loader\FilesystemLoader($templatesDirectory);
        $twig = new \Twig\Environment($loader, [
            'debug' => true,
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        echo $twig->render($view, $tplData);
    }
}