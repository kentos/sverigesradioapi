<?php

define("__ROOT__", $_SERVER['DOCUMENT_ROOT']);

error_reporting(E_ERROR);

include_once(__ROOT__ . "/app/adodb5/adodb.inc.php");
include(__ROOT__ . "/app/db_info.inc.php");

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$db = ADONewConnection("mysql");
$db->debug=false;
$db->Connect($db_host, $db_user, $db_pass, $db_database);

#  Start routing, made simple
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if(!is_file(__ROOT__ . "/". $url) && $url != "/" && $url != "/index.php" && !strpos($url, "app/") > 0 ) {
	list($dummy, $controller, $action, $param1, $param2) = explode("/", $url);
	
	if($controller == "api") {
		$api_version = $action;
		
		$controller = $param1;
		$action = $param2;
		
		include(__ROOT__ . "/api/api_". $api_version .".php");
		
		exit;
	} else {
		// Do nothing for now
	}
}