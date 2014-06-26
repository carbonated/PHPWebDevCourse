<?php

class User {

	private $username;
	private $email;
	private $data = array();

	public function __construct($username, $email) {
		$this->setUsername($username);
		$this->setEmail($email);
	}
	
	public function getUsername() {
		return $this->username;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function __set($name, $value) {
		$this->data[$name] = $value;
	}
	
	public function __get($name) {
		return $this->data[$name];
	}
	
}