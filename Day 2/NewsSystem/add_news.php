<?php
$title = 'Добави новина';
include './includes/header.php';
include './includes/menu.php';
?>
<div id="container">
	<h1 class="center-text">Начало:</h1>
	<hr>
	<?php
	if (isset($_POST['submit'])) {
		

		$news_title = trim((string) $_POST['news_title']);
		$news_content = trim((string) $_POST['news_content']);
		
		echo '<pre>'.print_r($_FILES, true).'</pre>';
		$news_photo = uniqid($_FILES['news_photo']['name']).'.jpg';
		move_uploaded_file($_FILES['news_photo']['tmp_name'], './uploads/'.$news_photo);

		if (mb_strlen($news_title) > 5) {
			
			$time = time();
			$user_id = 1;

			$connection = mysqli_connect('localhost', 'root', '', 'news');
			if (!$connection) {
				exit;
			}


			$query = mysqli_query($connection, 'INSERT INTO `news` (user_id, title, content, photo, time) VALUES("' . mysqli_real_escape_string($connection, $user_id) . '", "' . mysqli_real_escape_string($connection, $news_title) . '", "' . $news_content . '", "' . $news_photo . '", "' . $time . '")');
			if (!$query) {
				echo mysqli_error($connection);
			}
		} else {
			echo "Sorry";
		}
	}
	?>
	<form method="POST" action="" enctype="multipart/form-data">
		Заглавие:<br>
		<input type="text" name="news_title"><br>
		Снимка: <input type="file" name="news_photo"><br>
		Описание на новината:<br>
		<textarea name="news_content"></textarea><br>
		<input type="submit" name="submit" value="Добави новина!">
	</form>
</div>
<?php
include './includes/footer.php';
?>