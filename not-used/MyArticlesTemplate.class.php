<?php

namespace app\Views;

/**
 * Sablona pro vlastni clanky
 */
class MyArticlesTemplate implements IView
{
    /**
     * Metoda slouzi k vypsani sablony pro vlastni clanky
     * @param array $data - data stranky
     */
    public function printOut(array $data)
    {
        $basicTemplate = new BasicTemplate();
        $basicTemplate->getHeader("a");
        echo $data["links"];
        $basicTemplate->getLoginForm();
        $basicTemplate->getFooter();
    }
}