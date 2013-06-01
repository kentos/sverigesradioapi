<?php

class Artist extends API {
	function Artist() {
		$this->API();
		
		$this->get_search();
		
		if(!$this->search_string > '' || $this->search_string > 0) {
			$this->put(array("status"=> "no data"));
		} else {
			$artist = $this->get_artist($this->search_string);
			$plays = $this->get_plays($artist);
			
			$unique_songs = array();
			
			foreach($plays as $p) {
				$unique_songs[$p['song_id']] = true;
			}
			
			$meta = array(
				"num_plays" => count($plays),
				"unique_songs"=> count($unique_songs)
			);
		
			$this->put(array("meta" => $meta, "artist" => $artist, "plays" => $plays));
		}
	}
	
	private function get_artist($artist) {
		
		if(!is_numeric($artist)) {
			$artist = strtolower($artist);
			$artist = str_replace("Å", "å", $artist);
			$artist = str_replace("Ä", "ä", $artist);
			$artist = str_replace("Ö", "ö", $artist);
			
			$sql = "SELECT * FROM artist WHERE lower(name) = \"{$artist}\" LIMIT 1";
		} else {
			$sql = "SELECT * FROM artist WHERE id = {$artist} LIMIT 1";
		}
		
		$artist = $this->db->GetRow($sql);
		
		return $artist;
	}
	
	private function get_plays($row) {
		
		$sql = "SELECT * FROM playlist WHERE artist_id = ". $row['id'] . " ORDER BY the_date DESC, the_time DESC";
		$plays = $this->db->GetArray($sql);
		
		return $plays;
	}
}