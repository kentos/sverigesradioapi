<?php

function get_playlist_by_date($date) {
	global $base_url;
	
	$doc = $base_url . $date;
	$content = cache_get_contents($doc, true);
	$rows = Array();
	$current_index = 0;
	
	phpQuery::newDocument($content)->find(".songlist");
	
	foreach(pq("tbody tr") as $tr) {
		
		if(pq($tr)->hasClass("expand-container")) {
			$rows[$current_index] = new stdClass;
			$rows[$current_index]->time = $time = pq("td.time", $tr)->text();
			$rows[$current_index]->artist = trim(pq("span.artist", $tr)->text());
			$rows[$current_index]->song = trim(pq("span.title", $tr)->text());
			$rows[$current_index]->date = $date;
		} elseif(pq($tr)->hasClass("expanded-content")) {
			$rows[$current_index]->composerinfo = str_replace("Kompositör: ", "", pq("span.composerinfo", $tr)->text());
			$rows[$current_index]->spotifylink = pq("a.spotify", $tr)->attr("href");
			
			$current_index++;
		}
	}
	
	return $rows;
}

function get_playlist_history($startdate, $nummonths = 6) {
	global $base_url;
	
	$months = $nummonths * 30; // Almost perfect!
	
	for($i=0; $i <= $months; $i++) {
		$date = date("Y-m-d", strtotime("-". $i ." day"));
		
		get_playlist_by_date($date);
		
	}
}