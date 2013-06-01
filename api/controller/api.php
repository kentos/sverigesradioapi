<?php

/*
	Inherited class for controllers in the API
*/

class API {
	function API() {
		global $db;
		
		$this->db = $db;
		
		$this->info = array(
			"apiName"=> "Independent API for Sveriges Radio",
			"apiAuthot"=> "Kent C / @kentos / Do what you have to do."
		);
	}
	
	function put($data) {
		header("Content-type: application/json");
		
		$json = array(
			"info" => $this->info,
			"data" => $data
		);
		
		echo json_encode($json);
	}
	
	function get_search() {
		// Fix some stuff in the search string
		$this->search_string = trim($_GET['s']);
		$this->search_string = addslashes($this->search_string);
		$this->search_string = urldecode($this->search_string);
		
		if(!strlen($this->search_string) > 0) {
			error_log("No search string provided");
		}
	}
}