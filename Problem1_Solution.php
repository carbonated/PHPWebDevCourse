<meta charset="utf-8">
<?php
/*
 * Масивът съдържа хората работещи в дадена компания.
 * Всеки елемент представлява вложен масив, в който се съдържа пълната информация за даден работник - име, стаж, заплата
 */
$companyWorkers = array(
	array(
		'name' => 'Петър',
		'experiance' => 3,
		'wage' => 600.0
	),
	array(
		'name' => 'Димитър',
		'experiance' => 1,
		'wage' => 450.0
	),
	array(
		'name' => 'Мария',
		'experiance' => 8,
		'wage' => 1000.0
	),
	array(
		'name' => 'Стоян',
		'experiance' => 12,
		'wage' => 1300.0
	),
	array(
		'name' => 'Георги',
		'experiance' => 10,
		'wage' => 1100.0
	),
	array(
		'name' => 'Елена',
		'experiance' => 15,
		'wage' => 1800.0
	),
	array(
		'name' => 'Веско',
		'experiance' => 15,
		'wage' => 1800.0
	)
);

/*
 * Компанията решава да даде еднократен бонус към заплатите на работниците както следва:
 * Хората със стаж над 5 години получават бонус 100лв
 * Хората със стаж над 10 години получават бонус 250лв
 * Хората с най-висок стаж получават бонус 700лв
 * Всички, които не влизат в описаните стажови диапазони получават бонус равен на 12лв за всяка прослужена година
 * 
 * Задача:
 * Да се изведат таблици на хората със съответните им стажове и заплати преди и след бонуса.
 */

$count = count($companyWorkers);
$topExp = 0;
for($i=0; $i<$count; $i++) {
	if($topExp < $companyWorkers[$i]['experiance']) {
		$topExp = $companyWorkers[$i]['experiance'];
	}
}

$companyWorkersBonus = array();
echo '<h1>Заплати преди бонус:</h1><table>'
. '<tr>'
. '<td>Име</td>'
. '<td>Стаж</td>'
. '<td>Заплата</td>'
. '</tr>';
foreach($companyWorkers as $worker) {
	echo '<tr>'
	. '<td>'.$worker['name'].'</td>'
	. '<td>'.$worker['experiance'].'</td>'
	. '<td>'.$worker['wage'].'</td>'
	. '</tr>';
	
	if($worker['experiance'] == $topExp) {
		$worker['wage'] += 700;
	} else if($worker['experiance'] >= 10) {
		$worker['wage'] += 250;
	} else if($worker['experiance'] >= 5) {
		$worker['wage'] += 100;
	} else {
		$worker['wage'] += $worker['experiance']*15;
	}
	
	$companyWorkersBonus[] = $worker;
}
echo '</table>';

echo '<h1>Заплати след бонус:</h1><table>'
. '<tr>'
. '<td>Име</td>'
. '<td>Стаж</td>'
. '<td>Заплата</td>'
. '</tr>';
foreach($companyWorkersBonus as $worker) {
	echo '<tr>'
	. '<td>'.$worker['name'].'</td>'
	. '<td>'.$worker['experiance'].'</td>'
	. '<td>'.$worker['wage'].'</td>'
	. '</tr>';
}
echo '</table>';
?>