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
			$ok = FALSE;
		}

		if ($ok) {
			include './includes/mysqli.php';
			$query = mysqli_query($connection, 'SELECT * FROM `users` WHERE username="' . mysqli_real_escape_string($connection, $username) . '"');
			if (!$query) {
				$data['errors'][] = 'MySQL грешка: ' . mysqli_error($connection); //Ако не е показваме грешка
			} else {
				if (mysqli_num_rows($query) == 0) {
					$data['errors'][] = 'Няма такъв потребител.';
				} else {
					$userData = mysqli_fetch_assoc($query);
				}
			}
		}
	}

	//Проверяваме ако масива е празен т.е. ако няма грешки
	if (empty($data['errors'])) {
		if (password_verify($password, $userData['password'])) {
			$_SESSION['isLogged'] = TRUE;
			$_SESSION['user_id'] = $userData['id'];
			$_SESSION['username'] = $username;

			$data['successMsg'] = 'Успешен вход!';
		} else {
			$data['log']['username'] = $username;
			$data['errors'][] = 'Грешна парола!';
		}
	} else {
		$data['log']['username'] = $username;
	}
}

$data['inc_page'] = './templates/' . $template_name . '/pages/login.php';

render($data, './templates/' . $template_name . '/layout.php');
