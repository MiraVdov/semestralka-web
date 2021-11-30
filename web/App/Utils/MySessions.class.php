<?php
namespace app\Utils;
/**
 * Trida slouzici k praci se session
 */
class MySessions
{
    /**@var string klic pro session*/
    private const SESSION_ID = "name";
    /**
     * Zahajeni session
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * Metoda nastaví data do session
     * @param array $data - data sessny
     */
    public function setSession(array $data){
        $_SESSION[self::SESSION_ID] = $data;
    }

    /**
     * Metoda kontroluje zda je nastavena session
     * @return bool - true - exsituje, false - neexistuje
     */
    public function isSessionSet(){
        return isset($_SESSION[self::SESSION_ID]);
    }

    /**
     * Metoda slouzi k precteni session
     * @return mixed|null
     */
    public function readSession(){
        if ($this->isSessionSet()) return $_SESSION[self::SESSION_ID];
        return null;
    }

    /**
     * Metoda odstrani session
     */
    public function removeSession(){
        unset($_SESSION[self::SESSION_ID]);
    }

    public function addNewSessionValue(string $key, $data){
        $_SESSION[$key] = $data;
    }
}