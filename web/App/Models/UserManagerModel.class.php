<?php

namespace app\Models;

use app\Utils\MyCookies;
use app\Utils\MySessions;

/**
 * Třída slouží ke správě uživatele
 */
class UserManagerModel
{
    /**@var MySessions $session - session*/
    private $session;
    /**@var DatabaseManagerModel $databaseManager - instance databaze manageru*/
    private $databaseManager;

    /**
     * Metoda vytvoří instance pro správu uživatelů
     */
    public function __construct()
    {
        $this->databaseManager = DatabaseManagerModel::getDatabaseModel();
        $this->session = new MySessions();
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
    public function registerNewUser(string $login, string $fullName, string $phoneNumber, string $email, string $password, int $pravo = 4, int $banned = 0):bool{
        $login = htmlspecialchars($login);
        $fullName = htmlspecialchars($fullName);
        $phoneNumber = htmlspecialchars($phoneNumber);
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
        $password = password_hash($password, PASSWORD_BCRYPT);
        $pravo = htmlspecialchars($pravo);
        $banned = htmlspecialchars($banned);

        return $this->databaseManager->registerNewUser($login, $fullName, $phoneNumber, $email, $password, $pravo, $banned);
    }

    /**
     * Metoda vraci zda je uzivatel prihlasen
     * @return bool - true prihlasen, false - neprihlasen
     */
    public function isUserLogged():bool{
        return $this->session->isSessionSet();
    }

    /**
     * Metoda prihlasi uzivatele
     * @param string $login - login uzivatele
     * @param string $password - heslo uzivatele
     * @return bool - true - uzivatel uspesne prihlasen, false - uziatel neexistuje
     */
    public function loginUser(string $login, string $password):bool{
        $login = htmlspecialchars($login);
        $password = htmlspecialchars($password);
        $user = $this->databaseManager->selectUserByLogin($login);

        if (count($user) > 0 && password_verify($password, $user[0]["heslo"]) && isset($user[0]["isBanned"]) && $user[0]["isBanned"] == 0){
            // return the first one
            $this->session->setSession($user[0]);
            return true;
        }
        else if (count($user) > 0 && !password_verify($password, $user[0]["heslo"])){
            return false;
        }
        else{
            if (isset($user[0]["isBanned"]))$GLOBALS["isBanned"] = 1;
            return false;
        }
    }

    /**
     * Metoda slouzi k odhlaseni uzivatele
     */
    public function logoutUser(){
        $this->session->removeSession();
    }

    /**
     * Metoda slouzi k zabanovani uzivatele
     * @param $userID - id banovaneho uzivatele
     * @return bool - podarilo se zabanovat uzivatele true/false
     */
    public function banUser($userID):bool{
        $userID = htmlspecialchars($userID);
        $this->deleteAllUsersOccurences($userID);

        return $this->databaseManager->banUnbanUser($userID, 1);
    }

    /**
     * Metoda slouzi k odbanovani uzivatele
     * @param $userID - id odbanovaneho uzivate
     * @return bool - podarilo se zabanovat uzivatele - true/false
     */
    public function unBanUser($userID):bool{
        $userID = htmlspecialchars($userID);

        return $this->databaseManager->banUnbanUser($userID, 0);
    }

    /**
     * Metoda vraci data uzivatele
     * nebo null
     */
    public function getUserInfo(){
        if ($this->isUserLogged()){
            $userData = $this->session->readSession();
            if ($userData == null){
                $this->logoutUser();
                return null;
            }
            else return $userData;
        }
        return null;
    }

    /**
     * Metoda vraci informace o pravu uzivatele nebo null
     */
    public function getUserRightInfo(){
        $userInfo = $this->getUserInfo();
        $right = 0;
        if ($userInfo != null)$right = $userInfo[1];
        else return null;

        $rightData = $this->databaseManager->selectFromTable(TABLE_RIGHTS,"id_pravo='$right'");
        // return the first one
        return ($rightData == null) ? null : $rightData[0];
    }

    /**
     * Metoda vraci vsechny hledane uzivatele serazene podle id
     * @return array - pole uzivatelu
     */
    public function getAllUsers():array{
        return $this->databaseManager->selectFromTable(TABLE_USER, "",ID_UZIVATEL);
    }

    /**
     * Metoda vraci vsechny prava serazene podle id
     * @return array - pole uzivatelu
     */
    public function getAllRights():array{
        return $this->databaseManager->selectFromTable(TABLE_RIGHTS, "",ID_RIGHT);
    }

    /**
     * Metoda vraci vsechny recenzenty daneho clanku clanku
     * @param int $articleID
     * @return array
     */
    function getAllArticleReviewers(int $articleID): array{
        $articleID = htmlspecialchars($articleID);
        $reviews = $this->databaseManager->getAllArticleReviews($articleID);
        $articleReviewers = array();
        $index = 0;

        foreach ($reviews as $review){
            $usedID = $review["id_recenzenta"];
            $user = $this->databaseManager->selectFromTable(TABLE_USER, "id_uzivatel = '$usedID'");
            $articleReviewers[$index++] = $user[0];
        }

        return $articleReviewers;
    }

    /**
     * Metoda vraci pro dany clanek všechny dostpune recenzenty. (ps ty kteří ještě daný článek nerecenzovali)
     * @param int $articleID
     * @return array
     */
    function getAllPossibleReviewers(int $articleID): array{
        $articleID = htmlspecialchars($articleID);
        $usedReviewers = array();
        $reviews = $this->databaseManager->getAllArticleReviews($articleID);

        for ($i = 0; $i < sizeof($reviews); $i++){
            $usedReviewers[$i] = $reviews[$i]["id_recenzenta"];
        }

        $allReviewers = $this->databaseManager->selectFromTable(TABLE_USER, "id_pravo = 3 AND isBanned = 0");
        $g = sizeof($allReviewers);
        for ($i = 0; $i < $g; $i++) {
            for ($j = 0; $j < sizeof($usedReviewers); $j++) {
                if ($allReviewers[$i]["id_uzivatel"] == $usedReviewers[$j]){
                    unset($allReviewers[$i]);
                    break;
                }
            }
        }

        return $allReviewers;
    }

    /**
     * Metoda odebere uživatele od přiazeného článku
     * @param int $reviewerID
     * @param $articleID
     * @return bool
     */
    function removeReviewer(int $reviewerID, $articleID): bool{
        $reviewerID = htmlspecialchars($reviewerID);
        $articleID = htmlspecialchars($articleID);

        $article = $this->databaseManager->selectArticles($articleID);

        if ($article[0]["id_stav"] != 3){
            $this->databaseManager->updateArticleStatus($articleID, 3);
        }
        return $this->databaseManager->deleteReviews($reviewerID, $articleID);
    }

    /**
     * Metoda slouzi ke zmene uzivatelske role
     * @param int $userID
     * @param $rightID
     * @return bool
     */
    function changeUserRole(int $userID, $rightID): bool{
        $userID = htmlspecialchars($userID);
        $rightID = htmlspecialchars($rightID);

        $this->deleteAllUsersOccurences($userID);

        return $this->databaseManager->changeUserRole($userID, $rightID);
    }

    /**
     * If user right was reviewer - method will delete all his reviews and their article status will be set to 3
     * If user right was author - method will delete all his articles
     * @param $userID - id uzivatele
     */
    private function deleteAllUsersOccurences($userID){
        $userID = htmlspecialchars($userID);

        $user = $this->databaseManager->selectUser($userID);
        if ($user[0]["id_pravo"] == 3){
            //$this->databaseManager->de
            $articles = $this->databaseManager->selectReview($userID);
            foreach ($articles as $article){
                $articleID = $article["id_clanku"];
                $this->databaseManager->updateArticleStatus($articleID, 3);
            }
            $this->databaseManager->deleteReviews($userID);

        }else if ($user[0]["id_pravo"] == 4){
            $this->databaseManager->deleteUsersArticles($userID);
        }
    }

    /**
     * funkce vraci uzivtele podle emailu
     * @param $mail
     * @return array
     */
    function getUserByEmail($mail):array{
        $mail = htmlspecialchars($mail);
        if ($mail == "") return [];

        return $this->databaseManager->selectUserByEmail($mail);
    }

    function sendMail($mail, $userID): bool{
        $to = htmlspecialchars($mail);
        $userID = htmlspecialchars($userID);
        $subject = "Změna hesla";
        $header = "From: Konference internet věcí";
        $ran1 = rand(0,9);
        $ran2 = rand(0,9);
        $ran3 = rand(0,9);
        $ran4 = rand(0,9);

        $this->session->addNewSessionValue("ranData", array($ran1, $ran2, $ran3, $ran4));
        $this->session->addNewSessionValue("userID", $userID);

        $msg = "Kód:\n".$ran1." ".$ran2." ".$ran3." ".$ran4." ";
        $msg = wordwrap($msg,70);

        return mail($to, $subject, $msg,  $header);
    }

    /**
     * Metoda zmeni uzivatelovo heslo
     * @param $userID
     * @param $password
     * @return bool
     */
    function resetPassword($userID, $password): bool {
        $userID = htmlspecialchars($userID);
        $password = htmlspecialchars($password);
        $password = password_hash($password, PASSWORD_BCRYPT);
        echo $userID;
        echo $password;

        return $this->databaseManager->updatePassword($userID, $password);

    }
}