<?php

class Singleton {
	
	public $number=10;
	
	private static $instance=NULL;
	
	private function __construct() {
		
	}
	
	public static function getInstance() {
		if(self::$instance == NULL) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
}
