<?php
session_start();
if (isset($_SESSION['isLogged'])) exit; /* Ако потребителя има в сесията си
	 * isLogged, то значи е логнат и не му трябва да влиза отново
	 */

define('INC', TRUE); //Вижте коментара в index.php файла

$title = 'Логин';
include './includes/header.php';
include './includes/menu.php';
?>
<div id="container">
	<h1 class="center-text">Логин:</h1>
	<hr>
	<?php
	//Проверяваме дали е натиснат бутона submit
	if (isset($_POST['submit'])) {

		//Нормализираме данните
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

		$errors = array();  //Създаваме празен масив, в който евентуално ще слагаме грешки

		/* В последствие правим проверки и ако нещо не е наред превръщаме $errors
		 * в масив и добавяме всяка грешка в него
		 */

		if ($username == NULL || $password == NULL) {
			$errors[] = 'Всички полета са задължителни!';
		} else {
			$ok = TRUE; //Създаваме булева, която да е истина
			if (mb_strlen($username) < 4 || mb_strlen($username) > 20) {
				$errors[] = 'Потребителското име трябва да съдържа между 4 и 20 символа!';
				$ok = FALSE; //Ако изкара грешка за потребителското име я презаписваме на FALSE
			}
			if (mb_strlen($password) < 4 || mb_strlen($password) > 15) {
				$errors[] = 'Паролата трябва да е между 4 и 15 символа!';
			}
			
			if($ok) {
				include './includes/mysqli.php';
				$query = mysqli_query($connection, 'SELECT * FROM `users` WHERE username="'.mysqli_real_escape_string($connection, $username).'"');
				if (!$query) {
					echo 'MySQL грешка: ' . mysqli_error($connection); //Ако не е показваме грешка
				} else {
					if(mysqli_num_rows($query) == 0) {
						$errors[] = 'Няма такъв потребител.';
					} else {
						$userData = mysqli_fetch_assoc($query);
					}
				}
			}
		}

		//Проверяваме ако масива е празен т.е. ако няма грешки
		if (empty($errors)) {
			if(password_verify($password, $userData['password'])) {
				$_SESSION['isLogged'] = TRUE;
				$_SESSION['user_id'] = $userData['id'];
				$_SESSION['username'] = $username;
				
				echo 'Успешен вход!';
			} else {
				echo 'Грешна парола!';
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

	if (isset($errors) && !empty($errors)) {
		?>
		<form method="POST" action="">
			Потребителско име:<br>
			<input type="text" name="username" value="<?php echo $username; ?>"><br>
			Парола:<br>
			<input type="password" name="password"><br>
			<input type="submit" name="submit" value="Влез!">
		</form>
		<?php
	} else {
		?>
		<form method="POST" action="">
			Потребителско име:<br>
			<input type="text" name="username"><br>
			Парола:<br>
			<input type="password" name="password"><br>
			<input type="submit" name="submit" value="Влез!">
		</form>
		<?php
	}
	?>
</div>
<?php
include './includes/footer.php';
?>