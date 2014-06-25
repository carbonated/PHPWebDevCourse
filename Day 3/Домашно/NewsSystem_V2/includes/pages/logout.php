<?php

if (!defined('INC'))
	exit;

include './includes/config.php'; //Зареждаме главния конфигурационен файл на сайта

if (isset($_SESSION['isLogged'])) {/* Ако потребителя има в сесията си
 * isLogged, то значи е логнат и може да лог аутне
 */
	session_destroy();
	header('Location: index.php?page='); //Пренасочваме потребителя към началната страница
}