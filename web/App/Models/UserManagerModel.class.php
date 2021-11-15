<?php

namespace app\Models;

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
        $insertStatement = "id_pravo, jmeno, login, heslo, email, cislo, isBanned";
        $insertValues = "'$pravo', '$fullName', '$login', '$password', '$email', '$phoneNumber', '$banned'";

        return $this->databaseManager->insertIntoTable(TABLE_USER, $insertStatement, $insertValues);
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
        $where = "login='$login' AND heslo='$password'";
        $user = $this->databaseManager->selectFromTable(TABLE_USER,$where);

        if (count($user) > 0){
            // return the first one
            $this->session->setSession($user[0]);
            return true;
        }
        else return false;
    }

    /**
     * Metoda slouzi k odhlaseni uzivatele
     */
    public function logoutUser(){
        $this->session->removeSession();
    }

    public function updateUser(int $userID, int $rightID, string $name, string $login, string $password, string $email, string $number, int $banned = 0){

    }

    /**
     * Metoda slouzi k zabanovani uzivatele
     * @param $userID - id banovaneho uzivatele
     * @return bool - podarilo se zabanovat uzivatele true/false
     */
    public function banUser($userID):bool{
        return $this->databaseManager->updateInTable(TABLE_USER, "isBanned=1", "id_uzivatel=$userID");
    }

    /**
     * Metoda slouzi k odbanovani uzivatele
     * @param $userID - id odbanovaneho uzivate
     * @return bool - podarilo se zabanovat uzivatele - true/false
     */
    public function unBanUser($userID):bool{
        return $this->databaseManager->updateInTable(TABLE_USER, "isBanned=0", "id_uzivatel=$userID");
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
}