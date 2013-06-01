<?php

include("controller/api.php");
include("controller/". $controller .".php");

$ctrl = new $controller($action);
