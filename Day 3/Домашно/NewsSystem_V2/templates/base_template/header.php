<div id="header">
	<h1>PHP News System</h1>
	<?php
	if (isUserLogged()) {
		echo 'Добре дошъл, ' . htmlspecialchars($_SESSION['username']) . ' !';
	}
	?>
</div>