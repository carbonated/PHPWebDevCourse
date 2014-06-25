<?php

if (empty($data['errors'])) { //Проверяваме за грешки и ако няма изкарваме резултатите
	$i = 1;
	foreach ($data['latest_news'] as $row) {
		echo $i . '. <a href="./index.php?page=view&id=' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</a><br>';
		$i++;
	}
} else { //Но ако има изкарваме грешките
	echo '<ul>';
	foreach($data['errors'] as $error) {
		echo '<li>'.$error.'</li>';
	}
	echo '</ul>';
}
?>