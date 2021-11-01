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
     * Metoda prihlasi uzivatele
     * @param string $login - login uzivatele
     * @param string $password - heslo uzivatele
     * @return bool - true - uzivatel uspesne prihlasen, false - uziatel neexistuje
     */
    public function loginUser(string $login, string $password):bool{
        $where = "login='$login' AND heslo='$password'";
        $user = $this->databaseManager->selectFromTable(TABLE_USER,$where);

        if (count($user) > 0){
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

    /**
     * Metoda vraci zda je uzivatel prihlasen
     * @return bool - true prihlasen, false - neprihlasen
     */
    public function isUserLogged():bool{
        return $this->session->isSessionSet();
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

        return $this->databaseManager->insertIntoTable(TABLE_USER, $insertStatement, $insertValues);
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
     * Metoda vraci vsechny hledane uzivatele serazene podle id
     * @return array - pole uzivatelu
     */
    public function getAllUsers():array{
        return $this->databaseManager->selectFromTable(TABLE_USER, "",ID_UZIVATEL);
    }

    /**
     * Metoda vraci jmeno uzivatele nebo null
     */
    public function getUserName(){
        $userData = $this->getUserInfo();
        return ($userData == null) ?  null: $userData[2];
    }

    /**
     * Metoda vraci pravo uzivatele nebo null
     */
    public function getUserRight(){
        $userData = $this->getUserInfo();
        return ($userData == null) ?  null: $userData[1];
    }

    /**
     * Metoda vraci jmeno prava nebo null
     */
    public function getUserRightInfo(){
        $right = $this->getUserRight();
        if ($right != null) return $this->databaseManager->selectFromTable(TABLE_RIGHTS,"id_pravo='$right'");
        else return null;
    }

    /**
     * Metoda vraci jmeno uzivatelovo prava
     * @return mixed
     */
    public function getUserRightName(){
        $userRight = $this->getUserRightInfo();
        // beru prvni pozici v poli pokud není null
        return ($userRight != null) ? $userRight[0]["nazev"] : null;
    }
}