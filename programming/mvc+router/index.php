<?php
// router
require 'Router/Router.php';

// controllers

// models
// require_once "Model/traits\ValidatePHP_ID.php";
// require_once 'Model/DataHandler-v3.2.php';
// require_once 'Model/DataValidator-v3.2.php';
// require_once 'Model/FileHandler-v1.php';
// require_once 'Model/HtmlElements-v1.1.php';
// require_once 'Model/PhpUtilities-v2.php';
// require_once 'Model/SecurityHeaders-v1.php';
// require_once 'Model/SessionModel.php';
// require_once 'Model/TemplatingSystem-v1.php';


$Router = new Router(5);

echo $Router->return;

?>
