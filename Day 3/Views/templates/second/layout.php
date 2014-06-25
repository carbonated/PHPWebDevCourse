<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $data['title']; ?></title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="./templates/first/css/style.css">
	</head>
	<body>
		<div id="content">
			<?php
			include $data['header_inc'];
			include $data['menu_inc'];
			?>

			<div id="container">
				<h1 class="center-text">Начало:</h1>
				<hr>
			</div>

			<div class="clear-fix"></div>
			<?php
			include $data['footer_inc'];
			?>
		</div>
	</body>
</html>