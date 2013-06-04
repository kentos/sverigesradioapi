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
		$this->search_string = $this->sanitize_query($_GET['s']);
		
		if(!strlen($this->search_string) > 0) {
			error_log("No search string provided");
		}
	}
	
	function get_date_range() {
		$this->start_date = $this->sanitize_query($_GET['start']);
		$this->end_date = $this->sanitize_query($_GET['end']);
		
		if($this->test_date($this->start_date) && $this->test_date($this->end_date)) {
			return array(
				"start_date"=> $this->start_date,
				"end_date"=> $this->end_date
			);
		} else {
			return false;
		}
		
	}
	
	function test_date($d) {
		return $d;
	}
	
	function sanitize_query($str) {
		$str = trim($str);
		$str = addslashes($str);
		$str = urldecode($str);

		return $str;
	}
}