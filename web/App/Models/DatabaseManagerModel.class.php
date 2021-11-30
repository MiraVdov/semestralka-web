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
            $data = $this->exectuteQuery($query);
            return ($data != null);
        }

        /**
         * Metoda slouzi k pridani clanku s osetrenim
         * @param string $content
         * @param $date
         * @param int $userID
         * @param string $name
         * @param $file
         * @return bool
         */
        public function insertNewArticle(string $content, $date, int $userID, string $name, $file): bool{
            $insertStatement = "obsah, datum, id_uzivatel, nadpis, pdf, id_stav";
            $insertValues = ":content, :date, :userID, :name, '$file', :stateID";

            $query = "INSERT INTO ". TABLE_ARTICLES ." ($insertStatement) VALUES ($insertValues)";
            $result = $this->pdo->prepare($query);
            $result->bindValue(":content", $content);
            $result->bindValue(":date", $date);
            $result->bindValue(":userID", $userID);
            $result->bindValue(":name", $name);
            $result->bindValue(":stateID", 3);

            if ($result->execute()) return true;
            return false;
        }

        /**
         * Metoda slouzi k upraveni clanku
         * @param string $content
         * @param $date
         * @param string $name
         * @param $file
         * @param $articleID
         * @return bool
         */
        public function updateArticle(string $content, $date, string $name, $file, $articleID): bool{
            $insertStatementWithValues = "obsah=:content, datum='$date', nadpis=:name, pdf='$file', id_stav= '3'";
            $whereStatement = "id_clanku = $articleID";
            $query = "UPDATE ". TABLE_ARTICLES. " SET $insertStatementWithValues WHERE $whereStatement";
            $result = $this->pdo->prepare($query);
            $result->bindValue(":content", $content);
            $result->bindValue(":name", $name);

            if ($result->execute()) return true;
            return false;
        }

        /**
         * Metoda slouzic k odstraneni vsech recenzi clanku
         * @param int $articleID
         * @return bool
         */
        function deleteArticleReviews(int $articleID): bool{
            $query = "DELETE FROM ". TABLE_REVIEWS ." WHERE id_clanku = :articleID";
            $result = $this->pdo->prepare($query);
            $result->bindValue(":articleID", $articleID);

            if ($result->execute()) return true;
            return false;
        }

        /**
         * Metoda slouzi k odstraneni clanku
         * @param int $articleID
         * @return bool
         */
        function deleteArticle(int $articleID): bool{
            $query = "DELETE FROM ". TABLE_ARTICLES ." WHERE id_clanku = :articleID";
            $result = $this->pdo->prepare($query);
            $result->bindValue(":articleID", $articleID);

            if ($result->execute()) return true;
            return false;
        }


        function deleteReviews(int $reviewerID, int $reviewID = -1): bool{
            if ($reviewID == -1){
                $query = "DELETE FROM ". TABLE_REVIEWS ." WHERE id_recenzenta = :reviewerID";
                $result = $this->pdo->prepare($query);
                $result->bindValue(":reviewerID", $reviewerID);
            }
            else{ // byl zadán reviewerID
                $query = "DELETE FROM ". TABLE_REVIEWS ." WHERE id_clanku = :articleID AND id_recenzenta = :reviewerID";
                $result = $this->pdo->prepare($query);
                $result->bindValue(":articleID", $reviewID);
                $result->bindValue(":reviewerID", $reviewerID);
            }

            if ($result->execute()) return true;
            return false;
        }

        /**
         * @param int $userID
         * @return array
         */
        function getAllUsersArticles(int $userID):array{
            $query = "SELECT * FROM ". TABLE_ARTICLES ." WHERE id_uzivatel = :userID ORDER BY datum DESC";
            $result = $this->pdo->prepare($query);
            $result->bindValue(":userID", $userID);

            if ($result->execute())return $result->fetchAll();
            return [];
        }

        /**
         * Metoda slouzi k ziskani vsech prirazenych clanku pro zadaneho autora
         * @param int $userID
         * @return array
         */
        function getAllAssignedArticles(int $userID): array{
            $orderBy = TABLE_ARTICLES .".datum DESC";
            $whereStatement = TABLE_REVIEWS .".id_recenzenta = :userID";
            $inner = TABLE_REVIEWS. " ON ". TABLE_ARTICLES . ".id_clanku = " . TABLE_REVIEWS . ".id_clanku";
            $m = TABLE_ARTICLES;
            $selection = "$m.id_clanku, $m.obsah, $m.datum, $m.id_uzivatel, $m.nadpis, $m.pdf, $m.id_stav";

            $query = "SELECT $selection FROM ". TABLE_ARTICLES ." INNER JOIN $inner WHERE $whereStatement ORDER BY $orderBy";
            $result = $this->pdo->prepare($query);
            $result->bindValue(":userID", $userID);

            if ($result->execute())return $result->fetchAll();
            return [];
        }

        /**
         * @param int $articleID
         * @return array
         */
        function getAllArticleReviews(int $articleID): array{
            $whereStatement = "id_clanku = :articleID";
            $query = "SELECT * FROM ". TABLE_REVIEWS. " WHERE $whereStatement ORDER BY id_recenzenta ASC";

            $result = $this->pdo->prepare($query);
            $result->bindValue(":articleID", $articleID);

            if ($result->execute())return $result->fetchAll();
            return [];
        }

        /**
         * Metoda slouzi k zakazani nebo povoleni clanku
         * @param int $articleID
         * @param int $status
         * @return true|false
         */
        function updateArticleStatus(int $articleID, int $status): bool{
            $whereStatement = "id_clanku = :articleID";
            $query = "UPDATE ". TABLE_ARTICLES. " SET id_stav = :status WHERE $whereStatement";
            $result = $this->pdo->prepare($query);
            $result->bindValue(":status", $status);
            $result->bindValue(":articleID", $articleID);

            if ($result->execute())return true;
            return false;
        }

        /**
         * Metoda slouzi k aktualizovani recenze
         * @param string $content
         * @param int $articleID
         * @param int $contentValue
         * @param int $formalValue
         * @param int $newestValue
         * @param int $languageValue
         * @param int $userID
         * @param $date
         * @param $reviewValue
         * @return bool
         */
        function updateReview(string $content, int $articleID, int $contentValue, int $formalValue, int $newestValue, int $languageValue, int $userID, $date, $reviewValue) :bool {
            $insertStatementWithValues = "datum=:date, obsah=:content, celkem=:reviewValue, obsahBody=:contentValue, formalnost=:formValue, novost=:newestValue, jazyk=:languageValue, zverejnena='1'";
            $whereStatement = "id_clanku=:articleID AND id_recenzenta = :userID";

            $query = "UPDATE ". TABLE_REVIEWS. " SET $insertStatementWithValues WHERE $whereStatement";

            $result = $this->pdo->prepare($query);
            $result->bindValue(":date", $date);
            $result->bindValue(":content", $content);
            $result->bindValue(":reviewValue", $reviewValue);
            $result->bindValue(":contentValue", $contentValue);
            $result->bindValue(":formValue", $formalValue);
            $result->bindValue(":newestValue", $newestValue);
            $result->bindValue(":languageValue", $languageValue);

            $result->bindValue(":articleID", $articleID);
            $result->bindValue(":userID", $userID);

            if ($result->execute()) return true;
            return false;
        }

        /**
         * Metoda slouzi k vytvoreni recenze
         * @param $date
         * @param $content
         * @param $articleID
         * @param $reviewerID
         * @return bool
         */
        function createReview($date, $content, $articleID, $reviewerID): bool{
            $insertStatement = "datum, obsah, id_clanku, id_recenzenta, celkem, obsahBody, formalnost, novost, jazyk, zverejnena";
            $insertValues = ":date, :content, :articleID, :reviewerID, '0', '0', '0', '0', '0', '0'";

            $query = "INSERT INTO ". TABLE_REVIEWS ." ($insertStatement) VALUES ($insertValues)";
            $result = $this->pdo->prepare($query);
            $result->bindValue(":content", $content);
            $result->bindValue(":date", $date);
            $result->bindValue(":reviewerID", $reviewerID);
            $result->bindValue(":articleID", $articleID);

            if ($result->execute()) return true;
            return false;
        }

        /**
         * Metoda slouzi k banovani nebo odbanovani uzivatele
         * @param int $userID
         * @param int $status
         * @return bool
         */
        function banUnbanUser(int $userID, int $status): bool{
            $query = "UPDATE ". TABLE_USER . " SET isBanned= :status WHERE id_uzivatel=:userID";

            $result = $this->pdo->prepare($query);
            $result->bindValue(":status", $status);
            $result->bindValue(":userID", $userID);

            if ($result->execute()) return true;
            return false;
        }

        /**
         * Metoda slouzi k zaregistrovani noveho uzivatele
         * @param string $login
         * @param string $fullName
         * @param string $phoneNumber
         * @param string $email
         * @param string $password
         * @param int $pravo
         * @param int $banned
         * @return bool
         */
        function registerNewUser(string $login, string $fullName, string $phoneNumber, string $email, string $password, int $pravo, int $banned):bool{
            $insertStatement = "id_pravo, jmeno, login, heslo, email, cislo, isBanned";
            $insertValues = ":right, :fullName, :login, :password, :email, :phoneNumber, :banned";

            $query = "INSERT INTO ". TABLE_USER . " ($insertStatement) VALUES ($insertValues)";
            $result = $this->pdo->prepare($query);
            $result->bindValue(":right", $pravo);
            $result->bindValue(":fullName", $fullName);
            $result->bindValue(":login", $login);
            $result->bindValue(":password", $password);
            $result->bindValue(":email", $email);
            $result->bindValue(":phoneNumber", $phoneNumber);
            $result->bindValue(":banned", $banned);

            if ($result->execute()) return true;
            return false;
        }

        /**
         * Metoda vraci hledany clanek
         * @param $articleID
         * @return array|false
         */
        function selectArticles($articleID):array{
            $whereStatement = "id_clanku = :articleID";
            $query = "SELECT * FROM ". TABLE_ARTICLES. " WHERE $whereStatement";

            $result = $this->pdo->prepare($query);
            $result->bindValue(":articleID", $articleID);

            if ($result->execute())return $result->fetchAll();
            return [];
        }

        /**
         * Metoda slouzi ke zmene role uzivatele
         * @param int $userID
         * @param $rightID
         * @return bool
         */
        function changeUserRole(int $userID, $rightID): bool{
            $updateStatementWithValues = "id_pravo = :rightID";
            $whereStatement = "id_uzivatel = :userID";
            $query = "UPDATE ". TABLE_USER . " SET $updateStatementWithValues WHERE $whereStatement";

            $result = $this->pdo->prepare($query);
            $result->bindValue(":rightID", $rightID);
            $result->bindValue(":userID", $userID);

            if ($result->execute()) return true;
            return false;
        }

        /**
         * Metoda vraci data vybraneho uzivatele
         * @param $userID
         * @return array|false
         */
        function selectUser($userID){
            $whereStatement = "id_uzivatel = :userID";
            $query = "SELECT * FROM ". TABLE_USER. " WHERE $whereStatement";

            $result = $this->pdo->prepare($query);
            $result->bindValue(":userID", $userID);

            if ($result->execute())return $result->fetchAll();
            return [];
        }

        /**
         * Metoda vraci recenze vybraneho uzivatele
         * @param $reviewerID
         * @return array|false
         */
        function selectReview($reviewerID){
            $whereStatement = "id_recenzenta = :reviewerID";
            $query = "SELECT * FROM ". TABLE_REVIEWS. " WHERE $whereStatement";

            $result = $this->pdo->prepare($query);
            $result->bindValue(":reviewerID", $reviewerID);

            if ($result->execute())return $result->fetchAll();
            return [];
        }

        /**
         * Metoda slouzi k vymazani vsech uzivatelovych clanku
         * @param int $userID
         * @return bool
         */
        function deleteUsersArticles(int $userID): bool{
            $query = "DELETE FROM ". TABLE_ARTICLES ." WHERE id_uzivatel = :userID";
            $result = $this->pdo->prepare($query);
            $result->bindValue(":userID", $userID);

            if ($result->execute()) return true;
            return false;
        }

        /**
         * Metoda vraci uzivatele s danym loginem nebo prazdne pole
         * @param $login
         * @return array
         */
        function selectUserByLogin($login):array{
            $whereStatement = "login = :login";
            $query = "SELECT * FROM ". TABLE_USER. " WHERE $whereStatement";

            $result = $this->pdo->prepare($query);
            $result->bindValue(":login", $login);

            if ($result->execute())return $result->fetchAll();
            return [];
        }

        /**
         * funkce vraci uzivtele podle emailu
         * @param $mail
         * @return array
         */
        function selectUserByEmail($mail): array{
            $whereStatement = "email = :email";
            $query = "SELECT * FROM ". TABLE_USER. " WHERE $whereStatement";

            $result = $this->pdo->prepare($query);
            $result->bindValue(":email", $mail);

            if ($result->execute())return $result->fetchAll();
            return [];
        }


        function updatePassword(int $userID, string $password): bool{
            $updateStatementWithValues = "heslo = :password";
            $whereStatement = "id_uzivatel = :userID";
            $query = "UPDATE ". TABLE_USER . " SET $updateStatementWithValues WHERE $whereStatement";

            $result = $this->pdo->prepare($query);
            $result->bindValue(":password", $password);
            $result->bindValue(":userID", $userID);

            if ($result->execute()) return true;
            return false;
        }
    }
