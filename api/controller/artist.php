<?php

class Artist extends API {
	function Artist() {
		$this->API();
		
		$this->get_search();
		
		$this->put(array("artist" => $this->search_string));
	}
}