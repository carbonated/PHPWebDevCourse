<?php
/*
 * Задача #1
 * Направете приложение, което изкарва на екрана числата от 1 до 100, като всяко от числата да бъде на нов ред.
 * Направете го по минимум 2 начина.
 */

//Начин #1
for($i=1;$i<=100;$i++) {
	echo $i.'<br>';
}

echo '<hr>'; //Хоризонтална разделителна линия

//Начин #2
$i = 1;
while($i<=100) {
	echo $i.'<br>';
	$i++;
}
?>