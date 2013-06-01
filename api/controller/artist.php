<?php

class Artist extends API {
	function Artist() {
		$this->API();
		
		$this->get_search();
		
		$artist = $this->get_artist($this->search_string);
		$plays = $this->get_plays($artist);
		$meta = array(
			"num_plays" => count($plays)
		);
		
		$this->put(array("meta" => $meta, "artist" => $artist, "plays" => $plays));
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