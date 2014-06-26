<?php

class User {
	
	protected $user_level;
	private $username;
	private $email;
	
	public function __construct($username, $email) {
		$this->setUsername($username);
		$this->setEmail($email);
		$this->setUser_level(0);
		echo $this->getEmail();
	}
	
	public function getUsername() {
		return $this->username;
	}

	private function getEmail() {
		return $this->email;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function setEmail($email) {
		$this->email = $email;
	}
	
	public function DeleteNews() {
		echo 'triq svoqta si novina';
	}
	
	public function setUser_level($user_level) {
		$this->user_level = $user_level;
	}
	
	public function getUser_level() {
		return $this->user_level;
	}


	
}
