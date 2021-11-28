<?php

namespace app\Models\phpScripts;
require_once("../../../myAutoloader.inc.php");
require_once("../../../settings.inc.php");
use app\Models\UserManagerModel;

$userManager = new UserManagerModel();
echo $userManager->changeUserRole($_POST["userID"], $_POST["rightID"]);