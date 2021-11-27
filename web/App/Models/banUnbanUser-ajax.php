<?php

namespace app\Models;
require_once("../../myAutoloader.inc.php");
require_once("../../settings.inc.php");

$userManager = new UserManagerModel();
if (isset($_POST["action"])){
    if ($_POST["action"] == "ban"){
        $userManager->banUser($_POST["userID"]);
        echo "Uživatel zabanován";
    }
    else if($_POST["action"] == "unban"){
        $userManager->unBanUser($_POST["userID"]);
        echo "Uživatel odbanován";
    }
}