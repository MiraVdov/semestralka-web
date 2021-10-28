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
        public static function getDatabaseModel():DatabaseModel{
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
            return (data != null);
        }

        /**
         * @param string $table - nazev tabulky
         * @param string $updateValues - sloupce s novymi hodnotami
         * @param string $whereStatement - dotaz na urcitou vlasnost
         * @return bool true dotaz se povedl - false - nepovedl se
         */
        public function updateInTable(string $table, string $updateValues, string $whereStatement):bool{
            $query = "UPDATE $table SET $updateValues WHERE $whereStatement";
            $data = $this->$this->exectuteQuery($query);
            return (data != null);
        }

        /**
         * Metoda vraci vsechny hledane uzivatele serazene podle id
         * @return array - pole uzivatelu
         */
        public function getAllUsers():array{
           return $this->selectFromTable(TABLE_USER, "",ID_UZIVATEL);
        }

        /**
         * Metoda prida noveho uzivatele do databaze
         * @param string $login - login uzivatele
         * @param string $fullName - cele jmeno uzivatele
         * @param string $phoneNumber - cislo uzivatele
         * @param string $email - emial uzivatele
         * @param string $password - heslo uzivatele
         * @return bool - podarilo se uzivatele pridat do databaze
         */
        public function registerNewUser(string $login, string $fullName, string $phoneNumber, string $email, string $password, int $pravo = 4):bool{
            $insertStatement = "id_pravo, jmeno, login, heslo, email, cislo";
            $insertValues = "'$pravo', '$fullName', '$login', '$password', '$email', '$phoneNumber'";

            return $this->insertIntoTable(TABLE_USER, $insertStatement, $insertValues);
        }
    }
