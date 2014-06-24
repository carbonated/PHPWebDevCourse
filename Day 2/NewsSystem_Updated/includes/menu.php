<?php
if(!defined('INC')) exit; //Погледнете коментара в includes/mysqli.php
?>
<div id="menu">
	<h1 class="center-text">Меню:</h1>
	<hr>
	<ul>
		<li><a href="./index.php">Начало</a></li>
		<?php
		if(isset($_SESSION['isLogged'])) {
		?>
		<li><a href="./add_news.php">Добави новина</a></li>
		<li><a href="./logout.php">Изход</a></li>
		<?php
		} else {
		?>
		<li><a href="./register.php">Регистрация</a></li>
		<li><a href="./login.php">Логин</a></li>
		<?php
		}
		?>
	</ul>
</div>