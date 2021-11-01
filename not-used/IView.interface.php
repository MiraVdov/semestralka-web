<?php

namespace app\Views;

/**
 * Metoda pro sablony
 */
interface IView
{

    /**
     * Metoda vypise html stranky
     * @param array $data - data stranky
     */
    public function printOut(array $data);
}

