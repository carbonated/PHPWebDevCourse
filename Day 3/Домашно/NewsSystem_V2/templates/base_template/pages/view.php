<?php
if (empty($data['errors'])) { //Проверяваме за грешки и ако няма визуализираме новината
	?>
	<h2><?php echo $data['news_data']['title']; ?></h2>
	<h3><?php echo $categories[$data['news_data']['cat']]; ?></h3>
	<h3>От <?php echo $data['news_data']['author']; ?></h3>
	<small>
		<?php
		/*
		 * функцията date приема 2 параметъра, като втория не е задължителен:
		 * 1. начинът по който да покаже датата (string) - http://bg2.php.net/manual/en/function.date.php
		 * 2. дата във формата на UNIX timestamp (ако не се посочи взима текущата дата time())
		 */
		echo date("d.m.yг. в H:i:sч.", $data['news_data']['time']);
		?>
	</small><br>
	<img src="./uploads/<?php echo $data['news_data']['photo']; ?>" width="50%" height="50%"><br>
	<p><?php echo $data['news_data']['content']; ?></p>
	<?php
} else { //Но ако има изкарваме грешките
	echo '<ul>';
	foreach ($data['errors'] as $error) {
		echo '<li>' . $error . '</li>';
	}
	echo '</ul>';
}
?>