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

/**Klic defaultni webove stranky*/
const DEFAULT_WEB_PAGE = "informace";

///Dostupné webové stránky
const WEB_PAGES = array(
    ///// stranka Informace /////
    "informace" => array(
        "title" => "Informace",

        "view_class_name" => \app\Views\InformationTemplate::class,
    ),

    ///// Stranka registrace //////
    "registrace" => array(
        "title" => "registrace",
    ),

    ///// Stranka program ///////
    "program" => array(
        "title" => "program",
    ),
);
