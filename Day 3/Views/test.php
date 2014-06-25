<?php
if(!isset($_GET['page'])) {
	$_GET['page'] = 'index';
}
$page = $_GET['page'];


switch($page) {
	case 'login':
		echo 'include login_asd.php';
	break;

	case 'register':
		echo 'include register.php';
	break;

	default:
		echo 'include index.php';
	break;
}