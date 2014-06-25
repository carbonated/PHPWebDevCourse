<?php
define('INC', TRUE);

if(isset($_GET['page'])) {
	$page = trim($_GET['page']);
} else {
	$page = '';
}

switch ($page) {
	case 'register':
		include './includes/pages/register.php';
	break;

	case 'login':
		include './includes/pages/login.php';
	break;

	case 'logout':
		include './includes/pages/logout.php';
	break;

	case 'add_news':
		include './includes/pages/add_news.php';
	break;

	case 'view':
		include './includes/pages/view.php';
	break;
	
	default :
		include './includes/pages/index.php';
	break;
}