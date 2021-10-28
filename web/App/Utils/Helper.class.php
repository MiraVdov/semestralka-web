<?php

namespace app\Utils;

use app\Models\DatabaseModel;

/**
 * Trida slouzi k zkraceni opakovani kodu pro login form a odkzay
 */
class Helper
{
    /**
     * Metoda pomaha s prihlasenim uzivatele aby se kod ve tridach neopakoval
     * @param DatabaseModel $db - databazovy model
     */
    public static function loginHelp(DatabaseModel $db){
        // kliklo se na tlačítko přihlásit
        if (isset($_POST["action"]) && $_POST["action"] == "login"){
            // je vyplněen login a heslo
            if (isset($_POST["login"]) && trim($_POST["login"]) != "" &&
                isset($_POST["password"]) && trim($_POST["password"]) != ""){
                if (!$db->isUserLogged()){
                    if($db->loginUser($_POST["login"], $_POST["password"])){
                        //vypsání alertu
                        echo "<script>setTimeout(() => { alert('Uživatel úspěšně přihlášen!') }, 100)</script>";
                    }
                    else{
                        echo "Nepodařilo se uživatele přihlásit";
                    }
                }
            }
        }
        //// bylo zmacknuto tlacitko odhlaseni
        else if(isset($_POST["action"]) && $_POST["action"] == "logout"){
            $db->logoutUser();
            // vypsání alertu
            echo "<script>setTimeout(() => { alert('Uživatel úspěšně odhlášen!') }, 100)</script>";
        }
    }

    /**
     * Metoda pomaha se zobrazenim spravnych odkazu
     * @param DatabaseModel $db - databazovy model
     */
    public static function linkHelp(DatabaseModel $db){
        $linkOutput = "";

        if ($db->isUserLogged()){
            $userRight = $db->getUserRight();
            $userName = $db->getUserName();
            $userRightName = $db->getUserRightName();
            switch ($userRight) {
                // superAdministrator a administrator
                case 2:
                case 1:
                    $linkOutput .= "<li class='nav-item' xmlns=\"http://www.w3.org/1999/html\"><a class='nav-link underline' href='index.php?page=clanky'>Recenze</a></li>
                           <li class='nav-item'><a class='nav-link underline' href='index.php?page=clanky'>Uživatelé</a></li>
                           <li class='nav-item'><div class='loggedUserWhiteText'><span><i class='fa fa-user'></i></span> $userName (<strong>$userRightName</strong>)<br>
                           <form method='post'><button type='submit' class='log-out-toRight' name='action' value='logout'><span><i class='fa fa-sign-out'> Odhlásit se</i></span></button></div></form></li>
                        </ul></div></div></nav>";
                    break;
                // Recenzant
                case 3:
                    $linkOutput .= "<li class='nav-item'><a class='nav-link underline' href='index.php?page=clanky'>Moje recenze</a></li>
                            <li class='nav-item'><div class='loggedUserWhiteText'><span><i class='fa fa-user'></i></span> $userName (<strong>$userRightName</strong>)<br>
                            <form method='post'><button class='log-out-toRight' name='action' value='logout'><span><i class='fa fa-sign-out'> Odhlásit se</i></span></button></div></form></li>
                        </ul></div></div></nav>";
                    break;
                // Autor
                case 4:
                    $linkOutput .= "<li class='nav-item'><a class='nav-link underline' href='index.php?page=clanky'>Moje články</a></li>
                           <li class='nav-item'><div class='loggedUserWhiteText'><span><i class='fa fa-user'></i></span> $userName (<strong>$userRightName</strong>)<br>
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