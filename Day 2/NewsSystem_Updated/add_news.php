<?php
session_start();
if(!isset($_SESSION['isLogged'])) exit;
define('INC', TRUE); //Вижте коментара в index.php файла
$title = 'Добави новина';
include './includes/header.php';
include './includes/menu.php';
?>
<div id="container">
	<h1 class="center-text">Добави новина:</h1>
	<hr>
	<?php
	//Проверяваме дали е натиснат бутона submit
	if (isset($_POST['submit'])) {

		//Нормализираме данните
		$news_title = trim((string) $_POST['news_title']);
		$news_content = trim((string) $_POST['news_content']);

		$errors = array(); //Създаваме празен масив, в който евентуално ще слагаме грешки

		/* В последствие правим проверки и ако нещо не е наред превръщаме $errors
		 * в масив и добавяме всяка грешка в него
		 */
		if ($news_title == NULL || $news_content == NULL || empty($_FILES)) {
			$errors[] = 'Всички полета са задължителни!';
		} else {
			if (mb_strlen($news_title) < 5) {
				$errors[] = 'Заглавието трябва да е от поне 5 символа!';
			}
			if (mb_strlen($news_content) < 10) {
				$errors[] = 'Съдържанието на новината трябва да съдържа поне 10 символа!';
			}
			/*
			 * Големината на файла в $_FILES['news_photo']['size'] е в байтове.
			 * => $_FILES['news_photo']['size'] / 1024 kB
			 * => ($_FILES['news_photo']['size'] / 1024) / 1024 MB
			 */
			$maxFileSize = 2 * 1024 * 1024; //2MB
			if ($_FILES['news_photo']['size'] > $maxFileSize) {
				$errors[] = 'Големината на прикачената снимка надхвърля <b>' . $maxFileSize . ' MB</b>!';
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
				$errors[] = 'Каченият файл не е снимка.';
			} else if (!move_uploaded_file($_FILES['news_photo']['tmp_name'], './uploads/' . $uniqueImageName)) { //Правим проверка дали файлът НЕ се е качил успешно
				$errors[] = 'Възникна грешка при качването на файла!';
			}
		}

		//Проверяваме ако масива е празен т.е. ако няма грешки
		if (empty($errors)) {

			$time = time(); //Създаваме променлива с UNIX Timestamp времето в момента
			$user_id = $_SESSION['user_id']; //Взимаме от сесията id-то на потребителя

			/*
			 * Тъй като ще работим с MySQL го include-ваме, за да се създаде връзка
			 */
			include './includes/mysqli.php';

			$query = mysqli_query($connection, 'INSERT INTO `news` (user_id, title, content, photo, time) VALUES("' . $user_id . '", "' . mysqli_real_escape_string($connection, $news_title) . '", "' . mysqli_real_escape_string($connection, $news_content) . '", "' . $uniqueImageName . '", "' . $time . '")');
			if (!$query) { //Проверяваме дали заявката е успешна
				echo 'MySQL грешка: ' . mysqli_error($connection); //Ако не е показваме грешка
			} else {
				echo 'Успешно добавихте новина!';
			}
			
		} else {
			//Ако има грешки показваме ги в подходящ вид:
			echo '<ul>';
			foreach ($errors as $errMsg) {
				echo '<li>' . $errMsg . '</li>';
			}
			echo '</ul>';
		}
	}

	/* Проверяваме дали има грешки и ако има показваме форма с попълнените
	 * данни от потребителя, за да не ги въвежда отново, а просто да ги редактира.
	 * Обърнете внимание, че PHP тага може да се затоври, но затварящата скоба
	 * на проверката не е затворена. Затова можем да пишем HTML код, след това
	 * отново да отворим PHP таг и да затворим проверката.
	 */
	if (isset($errors) && !empty($errors)) {
		?>
		<form method="POST" action="" enctype="multipart/form-data">
			Заглавие:<br>
			<input type="text" name="news_title" value="<?php echo $news_title; //Поставяме изпратените от формата данни, за да не ги пише отново потребителя, ако има грешка  ?>"><br>
			Снимка: <input type="file" name="news_photo"><br>
			Описание на новината:<br>
			<textarea name="news_content"><?php echo $news_content; ?></textarea><br>
			<input type="submit" name="submit" value="Добави новина!">
		</form>
		<?php
	} else {
		//В противен случай показваме чиста форма
		?>
		<form method="POST" action="" enctype="multipart/form-data">
			Заглавие:<br>
			<input type="text" name="news_title"><br>
			Снимка: <input type="file" name="news_photo"><br>
			Описание на новината:<br>
			<textarea name="news_content"></textarea><br>
			<input type="submit" name="submit" value="Добави новина!">
		</form>
		<?php
	}
	?>
</div>
<?php
include './includes/footer.php';
?>