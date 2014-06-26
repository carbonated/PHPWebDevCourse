<?php

class Animals {
	
	private $color;
	private $age;
	
	public function __construct($color, $age) {
		$this->color = $color;
		$this->age = $age;
	}
	
	public function Eat() {
		echo 'Am am';
	}
	
	public function Move() {
		
	}
	
}