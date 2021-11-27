<?php

namespace app\Models;
require_once("../../myAutoloader.inc.php");
require_once("../../settings.inc.php");

$articleManager = new ArticlesManagerModel();
echo $articleManager->deleteArticle($_POST["articleID"]);