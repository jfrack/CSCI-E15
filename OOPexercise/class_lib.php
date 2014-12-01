<?php

class person {

	var $name;
	public $height;
	protected $SSN;
	private $pin;

	/*
	function __construct() {

	}
	*/

	function __construct($persons_name) {
		$this->name = $persons_name;
	}

	function set_name($new_name) {
		$this->name = $new_name;
	}

	public function get_name() {
		return $this->name;
	}

}

?>