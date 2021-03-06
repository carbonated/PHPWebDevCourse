<?php
/*
 * Задача #5
 * Направете приложение, което да показва на екрана таблицата за умножение (1-10) в подходящ вид. Използвайте функция и цикъл.
 */

for($i=1;$i<=10;$i++) {
	$multipliedNum = getMultipliedNum($i); //Създаваме променлива, която взима резултата от функцията getMultipliedNum, който всъщност е масив с всички данни от умножението
	echo '<div style="float: left; margin-left:30px;">';
	foreach($multipliedNum as $data) { //Обхождаме масива и записваме всяка клетка във променлива $data
		echo $data['multiplicand'].' x '.$data['multiplier'].' = '.$data['result'].'<br>'; //Показваме в подходящ вид данните
	}
	echo '</div><div class="clear: both;"></div>';
}

/*
 * Обръщам внимание на нещо, което пропуснах да кажа на лекциите:
 * Функциите, за разлика от променливите могат да се извикват преди да са дефинирани т.е. можем да я използваме над кода за създаването й
 */
function getMultipliedNum($number) { //Фунцкията приема 1 параметър - числото, на което искаме да направим "таблица за умножение"
	$number = (int)$number; //Презаписваме променливата $number, която идва като параметър като я Type Cast-ваме към integer. По този начин дори ако посочим текст вместо число, фунцкията ще работи без грешки.
	$multipliedNumber = array(); //Създаваме масив, в който ще съхраним "таблицата за умножение" за даденото число
	for($i=1;$i<=10;$i++) {
		$multipliedNumber[] = array(//Създаваме вложен масив (масив в масива) за всяко число
			'multiplicand' => $number, //Записваме множимото число в клетка "multiplicand".
			'multiplier' => $i, //Записваме множителя в клетка "multiplier"
			'result' => $number*$i //Умножаваме множимото по множителя
		);
		//Така умножаваме посоченото число по числата от 1 до 10 и записваме във вложен масив
	}
	return $multipliedNumber; //След като приключи изпълнението си, фунцкията връща масива
}
?>