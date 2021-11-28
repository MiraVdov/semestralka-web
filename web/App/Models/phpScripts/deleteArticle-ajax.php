<?php

namespace app\Models\phpScripts;
require_once("../../../myAutoloader.inc.php");
require_once("../../../settings.inc.php");
use app\Models\ArticlesManagerModel;

$articleManager = new ArticlesManagerModel();
echo $articleManager->deleteArticle($_POST["articleID"]);