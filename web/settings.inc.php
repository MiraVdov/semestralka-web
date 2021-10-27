<?php
//////////////////////////////////////////////////////////////////
/////////////////  Globalni nastaveni aplikace ///////////////////
//////////////////////////////////////////////////////////////////

    /**Adresa serveru*/
    const DB_SERVER = "localhost";
    /**Nazev databaze*/
    const DB_NAME = "web-semestralka";
    /**Uzivatel databaze*/
    const DB_USER = "root";
    /**Heslo uzivatele databaze*/
    const DB_PASSWORD = "";

    /////////Nazev tabulek v DB//////////

    /**Tabulka s uživateli*/
    const TABLE_USER = "miravdov_uzivatel";
    /**Tabulka s právama*/
    const TABLE_RIGHTS = "miravdov_prava";

    ///////////
    const ID_UZIVATEL = "id_uzivatel";
    //////////
    /**Klic defaultni webove stranky*/
    const DEFAULT_WEB_PAGE = "information";


    ////////konstanty
    /**Nazev*/
    const TITLE = "title";
    /**klic pro nazev tridy sablony*/
    const VIEW_CLASS_NAME = "view_class_name";
    /**klic pro nazev tridy kontroleru*/
    const CONTROLLER_CLASS_NAME = "controller_class_name";

    ///Dostupné webové stránky
    const WEB_PAGES = array(
        ///// stranka Informace /////
        "information" => array(
            "title" => "informace",
            "view_class_name" => \app\Views\InformationTemplate::class,
            "controller_class_name" => \app\Controllers\InformationController::class,
        ),

        ///// Stranka registrace //////
        "registration" => array(
            "title" => "registrace",
            "view_class_name" => \app\Views\RegistrationTemplate::class,
            "controller_class_name" => \app\Controllers\RegistrationController::class,
        ),

        ///// Stranka programu ///////
        "program" => array(
            "title" => "program",
            "view_class_name" => \app\Views\ProgramTemplate::class,
            "controller_class_name" => \app\Controllers\ProgramController::class,
        ),

        "user_management" => array(
            "title" => "sprava-uzivatelu",
            "view_class_name" => \app\Views\UserManagement::class,
            "controller_class_name" => \app\Controllers\UserManagementController::class,
        ),
    );
