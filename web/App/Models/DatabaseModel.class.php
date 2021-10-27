<?php

    namespace app\Models;

    /**
     * Třída spravující databazi
     */
    class DatabaseModel{
        /** @var DatabaseModel $database  Singleton databazoveho modelu. */
        private static $database;

        /** @var PDO $pdo  Objekt pracujici s databazi prostrednictvim PDO. */
        private $pdo;

        /**Připojení k databázi*/
        private function __construct()
        {
            //připojení k databázi
            $this->pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
            //nastavení utf8
            $this->pdo->exec("set names utf8");
        }

        /**
         * Metoda vrací jedinou instanci databazoveho modelu
         * @return DatabaseModel - databazovy model
         */
        public static function getDatabaseModel(){
            if (empty(self::$database)) self::$database = new DatabaseModel();
            return self::$database;
        }
    }
