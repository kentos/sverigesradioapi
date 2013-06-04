<?php

class Toplist extends API {
	
	function Toplist() {
		$this->API();
		
		#$this->get_search();
		
		$dates = $this->get_date_range();
		
		if($dates === false) {
			$this->put(array("error"=> "no date range specified"));
		}
	}
}