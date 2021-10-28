<?php
// pripojeni autoloaderu
require_once("myAutoloader.inc.php");
// pripojeni nastaveni webu
require_once("settings.inc.php");

$app = new \app\ApplicationStart();

$app->appStart();