<?php

namespace app\Models\phpScripts;
require_once("../../../myAutoloader.inc.php");
require_once("../../../settings.inc.php");
use app\Models\UserManagerModel;

$userManager = new UserManagerModel();
$users = $userManager->getAllUsers();
$userLogins = array();
foreach ($users as $user){
    $userLogins[] = $user["login"];
}
echo implode(",", $userLogins);