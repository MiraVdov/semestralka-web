<?php

namespace app\Models;
require_once("../../myAutoloader.inc.php");
require_once("../../settings.inc.php");

$userManager = new UserManagerModel();
echo $userManager->changeUserRole($_POST["userID"], $_POST["rightID"]);