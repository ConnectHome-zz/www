<?php

require_once dirname(__FILE__) . '/lightmvc/frontController.php';

FrontController::$isDebug = false;
FrontController::$dirname = dirname(__FILE__);

$front = FrontController::dispatch();
