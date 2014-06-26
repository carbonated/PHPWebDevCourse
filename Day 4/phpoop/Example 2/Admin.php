<?php

class Admin extends User {
	
	public function __construct($username, $email) {
		parent::__construct($username, $email);
		echo $this->getEmail();
	}


	public function AddNews() {
		echo 'dobavqm...';
	}
	
	public function DeleteNews() {
		parent::DeleteNews();
		echo 'triq kakvoto si iskam';
	}
	
}
