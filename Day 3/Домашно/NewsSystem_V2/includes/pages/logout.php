<?php

if (!defined('INC'))
	exit;

include './includes/config.php'; //Зареждаме главния конфигурационен файл на сайта
include './includes/functions.php'; //Зареждаме файла с функциите

if (isUserLogged()) {/* Ако потребителя има в сесията си
 * isLogged, то значи е логнат и може да лог аутне
 */
	session_destroy();
	header('Location: index.php?page='); //Пренасочваме потребителя към началната страница
}