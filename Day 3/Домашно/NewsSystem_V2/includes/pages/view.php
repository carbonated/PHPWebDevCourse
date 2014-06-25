<?php
if(!defined('INC')) exit;

include './includes/config.php'; //Зареждаме главния конфигурационен файл на сайта
include './includes/functions.php'; //Зареждаме файла с функциите

$data = array();

$data['template_name'] = $template_name;
$data['inc_header'] = './templates/' . $template_name . '/header.php';

$data['inc_menu'] = './templates/' . $template_name . '/menu.php';
$data['menu_items'] = $menu;

$data['inc_footer'] = './templates/' . $template_name . '/footer.php';

$data['content_h1'] = 'Преглед на новина:';

$data['errors'] = array();
if(isset($_GET['id'])) {
	$id = (int)$_GET['id']; //Взимаме id-то и го cast-ваме до integer (число) т.е. правим нормализация

	include './includes/mysqli.php';

	$query = mysqli_query($connection, 'SELECT * FROM `news` WHERE id='.mysqli_real_escape_string($connection, $id));
	if(!$query) { //Проверяваме дали заявката е успешна
		$data['errors'][] = 'MySQL грешка: ' . mysqli_error($connection); //Ако не е добавяме грешка към масива с грешките
	}

	//Проверяваме дали в таблицата съществува новина с даденото $id
	if(mysqli_num_rows($query) == 0) {
		$data['errors'][] = 'Няма такава новина.';
	} else {
		//Взимаме в масив всички данни за новината
		$row = mysqli_fetch_assoc($query);

		//Презаписваме стойностите от масива като ги минаваме през htmlspecialchars функцията
		$row['title'] = htmlspecialchars($row['title']);
		$row['content'] = htmlspecialchars($row['content']);
		/*
		 * htmlspecialchars е функция която пречи на html-а да се изпълни,
		 * а вместо това го показва на екрана като текст. По този начин ако
		 * някой е написал html tag в заглавието или content-а няма да навреди
		 * на сайта.
		 */
		
		$data['page_title'] = 'Преглед на новина - '.$row['title'];

		$getAuthorQuery = mysqli_query($connection, 'SELECT username FROM `users` WHERE id="'.$row['user_id'].'"');
		if(!$getAuthorQuery) {
			$data['errors'][] = 'MySQL грешка: ' . mysqli_error($connection);
		} else {
			$authorRow = mysqli_fetch_assoc($getAuthorQuery);
			$row['author'] = htmlspecialchars($authorRow['username']); //Добавяме автора към масива с информацията за новината
			$data['news_data'] = $row; //Записваме данните за новината в масива с всички данни
		}
	}
} else {
	$data['errors'][] = 'Няма избрана новина.';
}

$data['inc_page'] = './templates/' . $template_name . '/pages/view.php';

render($data, './templates/' . $template_name . '/layout.php');
