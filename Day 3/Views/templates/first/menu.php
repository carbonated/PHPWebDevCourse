<div id="menu">
	<h1 class="center-text">Меню:</h1>
	<hr>
	<ul>
		<?php
		if(empty($data['errors'])) {
			foreach($data['menu_data'] as $button) {
				echo '<li><a href="'.$button['link'].'">'.$button['title'].'</a></li>';
			}
		} else {
			foreach($data['errors'] as $error) {
				echo $error.'<br>';
			}
		}
		?>
	</ul>
</div>