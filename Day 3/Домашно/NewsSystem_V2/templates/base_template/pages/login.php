<?php
if (!empty($data['errors'])) {
	echo '<ul>';
	foreach ($data['errors'] as $error) {
		echo '<li>' . $error . '</li>';
	}
	echo '</ul>';
	?>
	<form method="POST" action="">
		Потребителско име:<br>
		<input type="text" name="username" value="<?php echo $data['log']['username']; ?>"><br>
		Парола:<br>
		<input type="password" name="password"><br>
		<input type="submit" name="submit" value="Влез!">
	</form>
	<?php
} else {
	if(isset($data['successMsg'])) {
		echo $data['successMsg'];
	} else {
	?>
	<form method="POST" action="">
		Потребителско име:<br>
		<input type="text" name="username"><br>
		Парола:<br>
		<input type="password" name="password"><br>
		<input type="submit" name="submit" value="Влез!">
	</form>
	<?php
	}
}
?>