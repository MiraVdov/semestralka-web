<?php

    namespace app\Models;
    use PDOStatement;
    /**
     * Třída spravující databazi
     */
    class DatabaseManagerModel{
        /** @var DatabaseManagerModel $database  Singleton databazoveho modelu. */
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
         * @return DatabaseManagerModel - databazovy model
         */
        public static function getDatabaseModel():DatabaseManagerModel{
            if (empty(self::$database)) self::$database = new DatabaseManagerModel();
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
        public function selectFromTable(string $table, string $whereStatement = "", string $orderBy = "", string $selection = "*",string $innerJoin = ""):array{
            if ($selection == "") $selection = "*";

            $query = "SELECT $selection FROM ".$table
                .(($innerJoin == "") ? "" : " INNER JOIN $innerJoin")
                .(($whereStatement == "") ? "" : " Where $whereStatement")
                .(($orderBy == "") ? "" : " ORDER BY $orderBy");

            $data = $this->exectuteQuery($query);

            if ($data == null) return [];
            return $data->fetchAll();
        }

        /**
         * Metoda prida novy zaznam do tabulky
         * @param string $table - nazev tabulky
         * @param string $insertStatement - nazev sloupcu
         * @param string $insertValues - hodnoty do sloupcu
         * @return bool - true dotaz se povedl - false - nepovedl se
         */
        public function insertIntoTable(string $table, string $insertStatement, string $insertValues):bool{
            $query = "INSERT INTO $table ($insertStatement) VALUES ($insertValues)";
            $data = $this->exectuteQuery($query);
            return ($data != null);
        }

        /**
         * @param string $table - nazev tabulky
         * @param string $whereStatement - dotaz na urcite vlastnosti
         * @return bool - true dotaz se povedl - false - nepovedl se
         */
        public function deleteFromTable(string $table, string $whereStatement):bool{
            $query = "DELETE FROM $table WHERE $whereStatement";
            $data =  $this->exectuteQuery($query);
            return ($data != null);
        }

        /**
         * @param string $table - nazev tabulky
         * @param string $updateValues - sloupce s novymi hodnotami
         * @param string $whereStatement - dotaz na urcitou vlasnost
         * @return bool true dotaz se povedl - false - nepovedl se
         */
        public function updateInTable(string $table, string $updateValues, string $whereStatement):bool{
            $query = "UPDATE $table SET $updateValues WHERE $whereStatement";
            echo $query;
            $data = $this->exectuteQuery($query);
            return ($data != null);
        }
    }
