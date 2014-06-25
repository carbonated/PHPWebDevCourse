<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $data['page_title']; ?></title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="./templates/<?php echo $data['template_name']; ?>/css/style.css">
	</head>
	<body>
		<div id="content">
			<?php
			include $data['inc_header'];
			include $data['inc_menu'];
			?>

			<div id="container">
				<h1 class="center-text"><?php echo $data['content_h1']; ?></h1>
				<hr>
				<?php
				include $data['inc_page'];
				?>
			</div>

			<div class="clear-fix"></div>
			<?php
			include $data['inc_footer'];
			?>
		</div>
	</body>
</html>