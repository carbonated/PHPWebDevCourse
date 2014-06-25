<?php

if (!defined('INC'))
	exit;

include './includes/config.php'; //Зареждаме главния конфигурационен файл на сайта

if (!isset($_SESSION['isLogged'])) {
	header('Location: index.php?page=');
	exit;
}

include './includes/functions.php'; //Зареждаме файла с функциите

$data = array();

$data['page_title'] = 'Добави новина';
$data['template_name'] = $template_name;
$data['inc_header'] = './templates/' . $template_name . '/header.php';

$data['inc_menu'] = './templates/' . $template_name . '/menu.php';
$data['menu_items'] = $menu;

$data['inc_footer'] = './templates/' . $template_name . '/footer.php';

$data['content_h1'] = 'Добави новина';

$data['errors'] = array();
$data['categories'] = $categories;

//Проверяваме дали е натиснат бутона submit
if (isset($_POST['submit'])) {

	//Нормализираме данните
	$news_title = trim((string) $_POST['news_title']);
	$news_cat = (int) $_POST['news_cat'];
	$news_content = trim((string) $_POST['news_content']);

	/* В последствие правим проверки и ако нещо не е наред превръщаме $errors
	 * в масив и добавяме всяка грешка в него
	 */
	if ($news_title == NULL || $news_content == NULL || empty($_FILES)) {
		$data['errors'][] = 'Всички полета са задължителни!';
	} else {
		if (mb_strlen($news_title) < 5) {
			$data['errors'][] = 'Заглавието трябва да е от поне 5 символа!';
		}
		if (!array_key_exists($news_cat, $categories)) {
			$data['errors'][] = 'Няма такава категория!';
		}
		if (mb_strlen($news_content) < 10) {
			$data['errors'][] = 'Съдържанието на новината трябва да съдържа поне 10 символа!';
		}
		/*
		 * Големината на файла в $_FILES['news_photo']['size'] е в байтове.
		 * => $_FILES['news_photo']['size'] / 1024 kB
		 * => ($_FILES['news_photo']['size'] / 1024) / 1024 MB
		 */
		$maxFileSize = 2 * 1024 * 1024; //2MB
		if ($_FILES['news_photo']['size'] > $maxFileSize) {
			$data['errors'][] = 'Големината на прикачената снимка надхвърля <b>' . $maxFileSize . ' MB</b>!';
		}

		$allowedMimes = array('image/jpg', 'image/jpeg', 'image/png'); /* разрешени MIME типове
		 * повече информация - http://help.superhosting.bg/mime-types.html
		 */
		$allowedExtensions = array('jpg', 'jpeg', 'png'); //разрешени файлови разширения

		$fullFileName = explode('.', $_FILES['news_photo']['name']); //Запазваме оригиналното име на файла с разширението
		/*
		 * Казах Ви да помислите как може да вземете само името и само разширението.
		 * На помощ идва фунцкията explode, която разделя string на части спрямо даден символ.
		 * Тя приема 2 аргумента:
		 * 1 - разделител
		 * 2 - стринг
		 * като резултат връща масив, като в него добавя отделните части.
		 * Така ако ние имаме файла с име: moqta-qka-snimka.jpg и извикаме
		 * explode('.', 'moqta-qka-snimka.jpg') ще получим масив със
		 * следните стойности array('moqta-qka-snimka', 'jpg').
		 * Тъй като е възможно да има повече от 1 точка винаги взимаме последната
		 * стойност от масива с функцията end()
		 */
		$fileExt = end($fullFileName);

		/* Генерираме уникално име на качената снимка, за да няма колизии.
		 * Функцията rand() генерира случайно число. Използвам я в комбинация
		 * с uniqid за максимална сигурност.
		 */
		$uniqueImageName = uniqid(rand()) . '.' . $fileExt;

		/*
		 * фунцкията in_array проверява дали дадена стойност съществува в масив
		 * приема 2 параметъра:
		 * 1вия е стойността, която ще търсим
		 * 2рия е масивът, в който ще търсим
		 */

		//Проверяваме ако типа НЕ Е от посочените в масива $allowedMimes И ако разширението на файла НЕ Е от посочените в масива $allowedExtensions
		if (!in_array($_FILES['news_photo']['type'], $allowedMimes) && !in_array($fileExt, $allowedExtensions)) {
			$data['errors'][] = 'Каченият файл не е снимка.';
		} else if (!move_uploaded_file($_FILES['news_photo']['tmp_name'], './uploads/' . $uniqueImageName)) { //Правим проверка дали файлът НЕ се е качил успешно
			$data['errors'][] = 'Възникна грешка при качването на файла!';
		}
	}

	//Проверяваме ако масива е празен т.е. ако няма грешки
	if (empty($data['errors'])) {

		$time = time(); //Създаваме променлива с UNIX Timestamp времето в момента
		$user_id = $_SESSION['user_id']; //Взимаме от сесията id-то на потребителя

		/*
		 * Тъй като ще работим с MySQL го include-ваме, за да се създаде връзка
		 */
		include './includes/mysqli.php';

		$query = mysqli_query($connection, 'INSERT INTO `news` (user_id, title, cat, content, photo, time) VALUES("' . $user_id . '", "' . mysqli_real_escape_string($connection, $news_title) . '", "' . mysqli_real_escape_string($connection, $news_cat) . '" ,"' . mysqli_real_escape_string($connection, $news_content) . '", "' . $uniqueImageName . '", "' . $time . '")');
		if (!$query) { //Проверяваме дали заявката е успешна
			$data['errors'][] = 'MySQL грешка: ' . mysqli_error($connection); //Ако не е показваме грешка
		} else {
			$data['successMsg'] = 'Успешно добавихте новина!';
		}
	} else {
		$data['news_data']['title'] = $news_title;
		$data['news_data']['content'] = $news_content;
		$data['news_data']['cat'] = $news_cat;
	}
}

$data['inc_page'] = './templates/' . $template_name . '/pages/add_news.php';

render($data, './templates/' . $template_name . '/layout.php');
