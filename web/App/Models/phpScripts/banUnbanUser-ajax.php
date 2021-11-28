<?php

namespace app\Models\phpScripts;
require_once("../../../myAutoloader.inc.php");
require_once("../../../settings.inc.php");
use app\Models\UserManagerModel;

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