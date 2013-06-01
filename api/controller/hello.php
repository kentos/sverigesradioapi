<?php

class Hello extends API {
	
	function Hello() {
		$this->API();
		
		$this->date = date("Y-m-d");
		$this->put($this->date);
	}	
}