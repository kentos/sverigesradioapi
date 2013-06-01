<?php

function get_playlist_by_date($date) {
	global $base_url;
	
	$doc = $base_url . $date;
	$content = cache_get_contents($doc, false);
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

function add_the_artist($row) {
	global $db;
	
	$ins['name'] = $row->artist;
	$ins['insertdate'] = date("Y-m-d H:i:s");
	
	if(!$db->AutoExecute("artist", $ins, "INSERT")) {
		$sql = "SELECT id FROM artist WHERE name = \"{$row->artist}\" LIMIT 1";
		$artist = $db->GetRow($sql);
		
		return $artist['id'];
	} else {
		return $db->Insert_ID();
	}
}

function add_the_song($row, $artist_id) {
	global $db;
	
	if(!$artist_id > 0) error_log("no artist ID!");
	
	$ins['songname'] = $row->song;
	$ins['artist_id'] = $artist_id;
	$ins['composer'] = $row->composerinfo;
	$ins['insertdate'] = date("Y-m-d H:i:s");
	
	if(!$db->AutoExecute("song", $ins, "INSERT")) {
		$sql = "SELECT id FROM song WHERE songname = \"{$row->song}\" AND artist_id = {$artist_id} LIMIT 1";
		$song = $db->GetRow($sql);
		
		return $song['id'];
	} else {
		return $db->Insert_ID();
	}
}

function add_to_playlist($row, $artist_id, $song_id) {
	global $db;
	
	if(!$artist_id > 0 || !$song_id > 0) error_log("no artist and song");

	$ins['artist_id'] = $artist_id;
	$ins['song_id'] = $song_id;
	$ins['the_time'] = $row->time;
	$ins['the_date'] = $row->date;
	$ins['insertdate'] = date("Y-m-d H:i:s");
	$ins['spotifylink'] = $row->spotifylink;
	
	return $db->AutoExecute("playlist", $ins, "INSERT");
}