<?php
if(!defined('INC')) exit;

include './includes/config.php'; //Зареждаме главния конфигурационен файл на сайта
include './includes/functions.php'; //Зареждаме файла с функциите

$data = array();

$data['page_title'] = 'Начало';
$data['template_name'] = $template_name;
$data['inc_header'] = './templates/' . $template_name . '/header.php';

$data['inc_menu'] = './templates/' . $template_name . '/menu.php';
$data['menu_items'] = $menu;

$data['inc_footer'] = './templates/' . $template_name . '/footer.php';

$data['content_h1'] = 'Начало';

include './includes/mysqli.php'; //Трябва ни връзка с БД (базата данни), за да изкараме списък с новините

$data['errors'] = array(); //Създаваме си масив, в който евентуално ще събираме грешките

$query = mysqli_query($connection, 'SELECT id,title FROM `news` ORDER BY `id` DESC LIMIT 0,10');
/*
 * Заявката тук включва 2 нови неща - ORDER BY и LIMIT
 * ORDER BY - подрежда резултатите по стойността на дадено поле - ако полето е INT
 * ще ги подреди по покачване (ASC) или понижаване (DESC) на стойността.
 * Ако избраното поле е текстово ще го подреди по азбучен ред, дължина и т.н.
 * Синтаксиса на ORDER BY е: ORDER BY `поле` ASC/DESC
 * В конкретния случай заявката ще върне последните новини (DESC)
 * ------------------------------
 * LIMIT - колко резултата да върне заявката
 * Приема 2 числени аргумента. Първият е колко записа след първия да започне,
 * а втория е колко записа да вземе.
 * Синтаксиса на LIMIT е: LIMIT число, число
 * В конкретния случай заявката ще започне от първия резултат и ще вземе
 * общо 10 резултата.
 */
if (!$query) { //Проверяваме дали заявката е успешна
	$data['errors'][] = 'MySQL грешка: ' . mysqli_error($connection); //Ако не е добавяме грешка към масива с грешките
} else {
	if (mysqli_num_rows($query) > 0) { //Проверяваме дали има някакви върнати новини от заявката
		$data['latest_news'] = array(); // Създаваме масив, в който ще събираме всички новини от заявката
		while ($row = mysqli_fetch_assoc($query)) { //Итерираме през всички резултати, като запазваме данните в променливата $row
			$data['latest_news'][] = $row; //Добавяме данните за новината в масива
		}
	} else { //Ако няма - уведомяваме потребителя
		$data['errors'][] = 'Все още няма добавени новини.';
	}
}

$data['inc_page'] = './templates/' . $template_name . '/pages/latest_news.php';

render($data, './templates/' . $template_name . '/layout.php');
