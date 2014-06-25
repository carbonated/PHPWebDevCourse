<?php

if (!defined('INC'))
	exit;

include './includes/config.php'; //Зареждаме главния конфигурационен файл на сайта

if (isset($_SESSION['isLogged'])) {/* Ако потребителя има в сесията си
 * isLogged, то значи е логнат и не му трябва нова регистрация
 */
	header('Location: index.php?page='); //Пренасочваме потребителя към началната страница
	exit;
}

include './includes/functions.php'; //Зареждаме файла с функциите

$data = array();

$data['page_title'] = 'Регистрация';
$data['template_name'] = $template_name;
$data['inc_header'] = './templates/' . $template_name . '/header.php';

$data['inc_menu'] = './templates/' . $template_name . '/menu.php';
$data['menu_items'] = $menu;

$data['inc_footer'] = './templates/' . $template_name . '/footer.php';

$data['content_h1'] = 'Регистрация';

$data['errors'] = array(); //Създаваме празен масив, в който евентуално ще слагаме грешки

//Проверяваме дали е натиснат бутона submit
if (isset($_POST['submit'])) {

	//Нормализираме данните
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	/* В последствие правим проверки и ако нещо не е наред превръщаме $errors
	 * в масив и добавяме всяка грешка в него
	 */

	if ($username == NULL || $password == NULL) {
		$data['errors'][] = 'Всички полета са задължителни!';
	} else {
		$ok = TRUE; //Създаваме булева, която да е истина
		if (mb_strlen($username) < 4 || mb_strlen($username) > 20) {
			$data['errors'][] = 'Потребителското име трябва да съдържа между 4 и 20 символа!';
			$ok = FALSE; //Ако изкара грешка за потребителското име я презаписваме на FALSE
		}
		if (mb_strlen($password) < 4 || mb_strlen($password) > 15) {
			$data['errors'][] = 'Паролата трябва да е между 4 и 15 символа!';
		}

		/*
		 * създадохме променливата, за да оптимизираме приложението:
		 * няма смисъл да проверяваме дали има регистриран човек с даденото
		 * потребителско име ако то не отговаря на минималната и максималната
		 * дължина. Така това ще се случва само ако отговаря.
		 */
		if ($ok) {
			include './includes/mysqli.php';
			/* Правим заявка, която да вземе всички потребители, чийто ник е
			 * посоченият от потребителя
			 */
			$query = mysqli_query($connection, 'SELECT id FROM `users` WHERE username="' . mysqli_real_escape_string($connection, $username) . '"');
			if (!$query) { //Проверяваме дали заявката не е успешна
				$data['errors'][] = 'MySQL грешка: ' . mysqli_error($connection); //Ако не е показваме грешка
			} else {
				/*
				 * Правим проверка колко резултата е върнала заявката. Ако
				 * резултатите са повече от 0 очевидно има регистриран
				 * потребител с това потребителско име и добавяме съобщение
				 * за грешка към масива с грешките.
				 */
				if (mysqli_num_rows($query) > 0) {
					$data['errors'][] = 'Съществува потребител с това потребителско име!';
				}
			}
		}
	}

	//Проверяваме ако масива е празен т.е. ако няма грешки
	if (empty($data['errors'])) {
		$hashPassword = password_hash($password, PASSWORD_BCRYPT); /*
		 * В уеб ВИНАГИ паролите се хешират. Хеширащите алгоритми еднопосочно
		 * преобразуват даден стринг. НЕВЪЗМОЖНО е превръщането на ХЕШ в
		 * първоначалната му стойност. Ако по някаква причина сайтът ви бъде
		 * хакнат и хакерите имат достъп до базата данни те няма да могат да
		 * разберат истинските пароли на потребителите. Именно с тази цел
		 * се хешира всякаква сензитивна информация.
		 */
		$insertQuery = mysqli_query($connection, 'INSERT INTO `users` (username, password) VALUES("' . mysqli_real_escape_string($connection, $username) . '", "' . mysqli_real_escape_string($connection, $hashPassword) . '")');
		if (!$insertQuery) {
			$data['errors'][] = 'MySQL грешка: ' . mysqli_error($connection); //Ако не е показваме грешка
		} else {
			$data['successMsg'] = 'Регистрацията е успешна!';
		}
	} else {
		$data['reg']['username'] = $username;
	}
}

$data['inc_page'] = './templates/' . $template_name . '/pages/register.php';

render($data, './templates/' . $template_name . '/layout.php');
