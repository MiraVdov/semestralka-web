<?php

    /** @array Pripony souboru*/
    const FILE_EXTENSION = array(".class.php", ".interface.php");

    // automaticka registrace trid
    spl_autoload_register(function ($className){

        // slozim celou cestu k souboru bez pripony
        $fileName = dirname(__FILE__) ."\\". $className;

        // vyhledání správné přípony
        foreach (FILE_EXTENSION as $extension) {

            if (file_exists($fileName . $extension)){
                $fileName .= $extension;
                break;
            }
        }
        // připojím soubor
        require_once($fileName);
});