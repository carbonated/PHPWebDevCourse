<?php
if(!defined('INC')) exit;

function render($data, $inc) {
	include $inc;
}

function isUserLogged() {
	//Проверяваме дали в сесията на потребителя има ключ isLogged
	if(isset($_SESSION['isLogged'])) {
		return TRUE; //Ако съществува - значи е логнат и връщаме истина
	} else {
		return FALSE; //Ако не съществува - значи не е логнат и връщаме неистина
	}
}