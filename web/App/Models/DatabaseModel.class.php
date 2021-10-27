<?php

    namespace app\Models;
    use PDOStatement;
    /**
     * Třída spravující databazi
     */
    class DatabaseModel{
        /** @var DatabaseModel $database  Singleton databazoveho modelu. */
        private static $database;

        /** @var \PDO $pdo  Objekt pracujici s databazi prostrednictvim PDO. */
        private $pdo;

        /**Připojení k databázi*/
        private function __construct()
        {
            //připojení k databázi
            $this->pdo = new \PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
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

        /**
         * Metoda slouží k zpracování SQL dotazu
         * @param string $query - dotaz
         * @return null|PDOStatement - vysledek dotazu
         */
        private function exectuteQuery(string $query){
            $data = $this->pdo->query($query);

            if($data) return $data;
            echo $this->pdo->errorInfo()[2];
            return null;
        }

        /**
         * @param string $table - nazev tabulky
         * @param string $whereStatement - dotaz na urcite vlastnosti
         * @param string $orderBy - poradi
         * @return array - vraci pole vysledku hledani
         */
        public function selectFromTable(string $table, string $whereStatement = "", string $orderBy = ""):array{
            $query = "SELECT * FROM ".$table
                .(($whereStatement == "") ? "" : " Where $whereStatement")
                .(($orderBy == "") ? "" : " ORDER BY $orderBy");

            $data = $this->exectuteQuery($query);
            if (data == null) return [];
            return $data->fetchAll();
        }


        public function getAllUsers():array{
           return $this->selectFromTable(TABLE_USER, "",ID_UZIVATEL);
        }
    }
