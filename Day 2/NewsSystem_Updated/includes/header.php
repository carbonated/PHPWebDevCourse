<?php
if(!defined('INC')) exit; //Погледнете коментара в includes/mysqli.php
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="./css/style.css">
	</head>
	<body>
		<div id="content">
			<div id="header">
				<h1>PHP News System</h1>
				<?php
				if(isset($_SESSION['isLogged'])) {
					echo 'Добре дошъл, '.htmlspecialchars($_SESSION['username']).' !';
				}
				?>
			</div>