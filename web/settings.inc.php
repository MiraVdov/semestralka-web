<?php
//////////////////////////////////////////////////////////////////
/////////////////  Globalni nastaveni aplikace ///////////////////
//////////////////////////////////////////////////////////////////

/**Adresa serveru*/
const DB_SERVER = "localhost";
/**Nazev databaze*/
const DB_NAME = "miravdov_semestralka_web";
/**Uzivatel databaze*/
const DB_USER = "root";
/**Heslo uzivatele databaze*/
const DB_PASSWORD = "";

/////////Nazev tabulek v DB//////////

/**Tabulka s uživateli*/
const TABLE_USER = "miravdov_uzivatel";
/**Tabulka s právama*/
const TABLE_RIGHTS = "miravdov_pravo";

///////////
const ID_UZIVATEL = "id_uzivatel";
const ID_RIGHT = "id_pravo";
//////////
/**Klic defaultni webove stranky*/
const DEFAULT_WEB_PAGE = "information";


///Dostupné webové stránky
const WEB_PAGES = array(
    ///// stranka Informace /////
    "information" => array(
        "title" => "informace",
        "controller_class_name" => \app\Controllers\InformationController::class,
        "view_name" => "page-information.twig",
    ),

    ///// Stranka registrace //////
    "registration" => array(
        "title" => "registrace",
        "controller_class_name" => \app\Controllers\RegistrationController::class,
        "view_name" => "page-registration.twig",
    ),

    ///// Stranka programu ///////
    "program" => array(
        "title" => "program",
        "controller_class_name" => \app\Controllers\ProgramController::class,
        "view_name" => "page-program.twig",
    ),
    ////stranka spravy uzivatelu////
    "user-management" => array(
        "title" => "správa uživatelů",
        "controller_class_name" => \app\Controllers\UserManagementController::class,
        "view_name" => "page-user-management.twig",
    ),

    /////stranka vlasnich clanku/////
    "my-articles" => array(
        "title" => "články",
        "controller_class_name" => app\Controllers\MyArticlesController::class,
        "view_name" => "articles.twig",
    ),
);
