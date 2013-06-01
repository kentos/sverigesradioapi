<?php
#header("Content-type:application/json");

include("cache.php");
include("phpquery/phpQuery.php");
include("functions.php");

date_default_timezone_set('UTC');

$base_url = "http://sverigesradio.se/sida/latlista.aspx?programid=164&date=";
$date = date("Y-m-d");

$json = get_playlist_by_date($date);

