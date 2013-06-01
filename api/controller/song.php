<?php

class Song extends API {
	
	function Song() {
		$this->API();
		
		$this->get_search();
		
		$song = $this->get_song($this->search_string);
		$plays = $this->get_plays($song);
		$meta = array(
			"num_plays" => count($plays)
		);
		
		$this->put(array("meta" => $meta, "song" => $song, "plays" => $plays));
	}
	
	private function get_song($song) {

		if(!is_numeric($song)) {
			$song = strtolower($song);
			$song = str_replace("Å", "å", $song);
			$song = str_replace("Ä", "ä", $song);
			$song = str_replace("Ö", "ö", $song);
			
			$sql = "SELECT * FROM song WHERE lower(songname) = \"{$song}\" LIMIT 1";
		} else {
			$sql = "SELECT * FROM song WHERE id = {$song} LIMIT 1";
		}
		
		$song = $this->db->GetRow($sql);
		
		return $song;
	}
	
	private function get_plays($row) {
		
		$sql = "SELECT * FROM playlist WHERE song_id = ". $row['id'] . " ORDER BY the_date DESC, the_time DESC";
		$plays = $this->db->GetArray($sql);
		
		return $plays;
	}
}