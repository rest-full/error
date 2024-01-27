<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../config/pathServer.php';

use Restfull\Error\ErrorHandler;
use Restfull\Error\Exceptions;

$exemplo = new Exceptions('exemplo valido',404);
$error = new ErrorHandler();
$error->logError($exemplo);
echo $error->MVCHandling($exemplo);