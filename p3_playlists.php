<?php
#header("Content-type:application/json");

include("cache.php");
include("phpquery/phpQuery.php");

date_default_timezone_set('UTC');

$base_url = "http://sverigesradio.se/sida/latlista.aspx?programid=164&date=";
$date = date("Y-m-d");

$json = array();
$current_index = 0;
	
/* main loop for playlists */
for($i=0; $i <= 30; $i++) {
	$date = date("Y-m-d", strtotime("-". $i ." day"));
	$doc = $base_url . $date;
	
	$content = cache_get_contents($doc);
	
	phpQuery::newDocument($content)->find(".songlist");
	
	foreach(pq("tbody tr") as $tr) {
		
		if(pq($tr)->hasClass("expand-container")) {
			$json[$current_index] = (object) array(); // How the fuck do you do a object the easiest way??
			$json[$current_index]->time = $time = pq("td.time", $tr)->text();
			$json[$current_index]->artist = trim(pq("span.artist", $tr)->text());
			$json[$current_index]->song = trim(pq("span.title", $tr)->text());
			$json[$current_index]->date = $date;
		} else {
			$json[$current_index]->composerinfo = str_replace("Kompositör: ", "", pq("span.composerinfo", $tr)->text());
			$json[$current_index]->spotifylink = pq("a.spotify", $tr)->attr("href");
			
			$current_index++;
		}
		
		/* dev purpuse: prints the first 40 */
		if($current_index==40) {
			echo json_encode($json);
			exit;
		}
	}
}