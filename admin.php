<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include 'engine/functions/config.php';
include 'engine/functions/parsepages.php';

$loadpage = new Parsepages();
$loadpage->Init();

$loadpage->loadFunction('encrypt');
$loadpage->loadFunction('general');
$loadpage->loadFunction('sesion');
$loadpage->loadFunction('url');
$loadpage->loadFunction('debug');
$loadpage->loadFunction('secure');

$loadpage->showContent();


$loadpage->functions->debug->overrideDebug = false;
$loadpage->functions->debug->ShowDebug();