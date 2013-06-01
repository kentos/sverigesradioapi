<?php

if(!$controller > '') {
	header("Location: /");
	exit;
}

include("controller/api.php");
include("controller/". $controller .".php");

$ctrl = new $controller($action);
