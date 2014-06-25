<?php
session_start();
//Проверяваме дали е посочено id, ако не е спираме до тук
if(!isset($_GET['id'])) exit;

$id = (int)$_GET['id']; //Взимаме id-то и го cast-ваме до integer (число) т.е. правим нормализация

define('INC', TRUE); //Вижте коментара в index.php файла
include './includes/mysqli.php';

$query = mysqli_query($connection, 'SELECT * FROM `news` WHERE id='.mysqli_real_escape_string($connection, $id));
if(!$query) { //Проверяваме дали заявката е успешна
	echo 'MySQL грешка: ' . mysqli_error($connection); //Ако не е показваме грешка
	exit; //и спираме изпълнението на кода
}

//Проверяваме дали в таблицата съществува новина с даденото $id
if(mysqli_num_rows($query) == 0) {
	exit; //ако няма резултати спираме до тук
	//Няма никакъв проблем тук да напишем "няма такава новина"
}

$categories = array(
	0 => 'Всякакви',
	1 => 'Политически',
	2 => 'Sports',
	3 => 'Клюки'
);

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

$getAuthorQuery = mysqli_query($connection, 'SELECT username FROM `users` WHERE id="'.$row['user_id'].'"');
if(!$getAuthorQuery) {
	echo 'MySQL грешка: ' . mysqli_error($connection); //Ако не е показваме грешка
} else {
	$data = mysqli_fetch_assoc($getAuthorQuery);
	$author = htmlspecialchars($data['username']);
}

$title = 'Преглед на новина - '.$row['title'];
include './includes/header.php';
include './includes/menu.php';
?>
<div id="container">
	<h1 class="center-text">Преглеждане на новина:</h1>
	<hr>
	<h2><?php echo $row['title']; ?></h2>
	<h3><?php echo $categories[$row['cat']]; ?></h3>
	<h3>От <?php echo $author; ?></h3>
	<small>
		<?php
		/*
		 * функцията date приема 2 параметъра, като втория не е задължителен:
		 * 1. начинът по който да покаже датата (string) - http://bg2.php.net/manual/en/function.date.php
		 * 2. дата във формата на UNIX timestamp (ако не се посочи взима текущата дата time())
		 */
		echo date("d.m.yг. в H:i:sч.", $row['time']);
		?>
	</small><br>
	<img src="./uploads/<?php echo $row['photo']; ?>" width="50%" height="50%"><br>
	<?php
	/*$font = (int)$_GET['font'];
	setcookie('news_font_size', $font);
	*/
	?>
	<p><?php echo $row['content']; ?></p>
</div>
<?php
include './includes/footer.php';
?>