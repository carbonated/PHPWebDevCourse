<?php

include './inc/functions.php';

$template = 'second';

$data = array();
$data['title'] = 'Начало';
$data['header_inc'] = './templates/'.$template.'/header.php';
$data['menu_inc'] = './templates/'.$template.'/menu.php';
$data['footer_inc'] = './templates/'.$template.'/footer.php';

$data['menu_data'] = array();
for($i=1;$i<=10;$i++) {
	$data['menu_data'][] = array(
		'title' => 'Link '.$i,
		'link' => $i.'.html'
	);
}
$data['menu_data'][] = array(
	'title' => 'Вход',
	'link' => 'login.php'
);

$data['errors'] = array('Greshka1', 'Greshka2');

render($data, './templates/'.$template.'/layout.php');