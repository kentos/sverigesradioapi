<?php
/*
	Run this script once, or twice, to sync older days playlists
*/

// remove to run!
exit;

set_time_limit(3600);

include("cache.php");
include("../app/phpquery/phpQuery.php");
include("functions.php");
include("../app/config.inc.php");

date_default_timezone_set('UTC');

$base_url = "http://sverigesradio.se/sida/latlista.aspx?programid=164&date=";
$date = "2012-12-04"; //date("Y-m-d");

for($i=560;$i < 960; $i++) {
	$the_date = date("Y-m-d", strtotime("-". $i ." day"));
	
	$json = get_playlist_by_date($the_date);

	foreach($json as $row) {
		$artist_id = add_the_artist($row);
		$song_id = add_the_song($row, $artist_id);
		$msg = add_to_playlist($row, $artist_id, $song_id);
	}
	
	sleep(1);
	error_log("starting new date");
}