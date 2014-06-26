<?php

class User {
	
	private $session=TRUE;
	private static $instances = array();
	
	public function __construct() {
		self::$instances[] = $this;
	}

	public function delAll() {
		foreach (self::$instances as $instance) {
			$instance->setSession(FALSE);
		}
	}
	
	public function setSession($session) {
		$this->session = $session;
	}
	
}

$a = new User();
$b = new User();
$c = new User();

var_dump($a);
echo '<br>';
var_dump($b);
echo '<br>';
var_dump($c);


$b->delAll();


echo '<br><hr>';
var_dump($a);
echo '<br>';
var_dump($b);
echo '<br>';
var_dump($c);