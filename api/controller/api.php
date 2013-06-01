<?php

class API {
	function API() {
		$this->info = array(
			"apiName"=> "Independent API for Sveriges Radio"
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
		$this->search_string = $_GET['s'];
	}
}