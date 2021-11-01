<?php

namespace app\Utils;

use app\Models\DatabaseManagerModel;

/**
 * Trida slouzi k zkraceni opakovani kodu pro login form a odkzay
 */
class Helper
{
    /**
     * Metoda pomaha s prihlasenim uzivatele aby se kod ve tridach neopakoval (da se prihlasit z jakekoliv stranky)
     * @param DatabaseManagerModel $db - databazovy model
     */
    public static function loginHelp(DatabaseManagerModel $db){
        // kliklo se na tlačítko přihlásit
        if (isset($_POST["action"]) && $_POST["action"] == "login"){
            // je vyplněen login a heslo
            if (isset($_POST["login"]) && trim($_POST["login"]) != "" &&
                isset($_POST["password"]) && trim($_POST["password"]) != ""){
                if (!$db->isUserLogged()){
                    if($db->loginUser($_POST["login"], $_POST["password"])){
                        //vypsání alertu
                        echo "<script>setTimeout(() => {alert('Uživatel úspěšně přihlášen!') }, 100)</script>";
                        // refresh stranky
                        header('Refresh: 0.5');

                    }
                    else{
                        echo "<script>setTimeout(() => {alert('Zadány špatné přihlašovací údaje!') }, 100)</script>";
                        // refresh stranky
                        header('Refresh: 0.5');
                    }
                }
            }
        }
        //// bylo zmacknuto tlacitko odhlaseni
        else if(isset($_POST["action"]) && $_POST["action"] == "logout"){
            $db->logoutUser();
            // vypsání alertu
            echo "<script>setTimeout(() => {alert('Uživatel úspěšně odhlášen!') }, 100)</script>";
            // refresh stranky
            header('Refresh: 0.5');
        }
    }

    /**
     * Metoda pomaha se zobrazenim spravnych odkazu - nastavi odkazy ktere uzivatel uvidi podle jeho prava
     * @param DatabaseManagerModel $db - databazovy model
     */
    public static function linkHelp(DatabaseManagerModel $db){
        $linkOutput = "";

        if ($db->isUserLogged()){   // $data["isLogged"];
            $userRight = $db->getUserRight(); // $data["userRight"];
            $userName = $db->getUserName(); // $data["userName"];
            $userRightName = $db->getUserRightName();  // $data["userRightName"];
            switch ($userRight) {
                // superAdministrator a administrator
                case 2:
                case 1:
                    $linkOutput .= "<li class='nav-item' xmlns=\"http://www.w3.org/1999/html\"><a class='nav-link underline' href='index.php?page=clanky'>Recenze</a></li>
                           <li class='nav-item'><a class='nav-link underline' href='index.php?page=user-management'>Uživatelé</a></li>
                           <li class='nav-item'><div class='loggedUserWhiteText'><span><i class='fa fa-user'></i></span> $userName (<strong class='boldRight'>$userRightName</strong>)<br>
                           <form method='post'><button type='submit' class='log-out-toRight' name='action' value='logout'><span><i class='fa fa-sign-out'> Odhlásit se</i></span></button></div></form></li>
                        </ul></div></div></nav>";
                    break;
                // Recenzant
                case 3:
                    $linkOutput .= "<li class='nav-item'><a class='nav-link underline' href='index.php?page=clanky'>Moje recenze</a></li>
                            <li class='nav-item'><div class='loggedUserWhiteText'><span><i class='fa fa-user'></i></span> $userName (<strong class='boldRight'>$userRightName</strong>)<br>
                            <form method='post'><button class='log-out-toRight' name='action' value='logout'><span><i class='fa fa-sign-out'> Odhlásit se</i></span></button></div></form></li>
                        </ul></div></div></nav>";
                    break;
                // Autor
                case 4:
                    $linkOutput .= "<li class='nav-item'><a class='nav-link underline' href='index.php?page=my-articles'>Moje články</a></li>
                           <li class='nav-item'><div class='loggedUserWhiteText'><span><i class='fa fa-user'></i></span> $userName (<strong class='boldRight'>$userRightName</strong>)<br>
                           <form method='post'><button class='log-out-toRight' name='action' value='logout'><span><i class='fa fa-sign-out'> Odhlásit se</i></span></button></div></form></li>
                        </ul></div></div></nav>";
                    break;
                // neprihlaseny
                default:
                    $linkOutput .= "</ul><form class='d-flex' method='post' action='index.php?page=registration'>
                        <button class='btn btn-primary moveMenuButton' type='button' id='btnLogin'><span
                                    class='fa fa-sign-in'></span>Přihlášení</button>           
                        <button class='btn btn-primary moveMenuButton' type='submit'>Registrace</button>
                    </form></div></div></nav>";
                    break;

            }
        }
        else{
            // neprihlaseny
            $linkOutput .= "</ul><form class='d-flex' method='POST' action='index.php?page=registration'>
                        <button class='btn btn-primary moveMenuButton' type='button' id='btnLogin'><span
                                    class='fa fa-sign-in'></span> Přihlášení</button>           
                        <button class='btn btn-primary moveMenuButton' type='submit'>Registrace</button>
                    </form></div></div></nav>";
        }
        return $linkOutput;
    }
}