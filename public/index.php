<?php

ini_set('display_errors', TRUE);
error_reporting(-1);

require '../vendor/autoload.php';

$controller = new \SyntaxTreeApi\Controller\Controller();
$controller->process($_POST);