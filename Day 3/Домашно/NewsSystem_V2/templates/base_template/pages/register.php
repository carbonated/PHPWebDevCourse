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
		<input type="text" name="username" value="<?php echo $data['reg']['username']; ?>"><br>
		Парола:<br>
		<input type="password" name="password"><br>
		<input type="submit" name="submit" value="Регистрирай се!">
	</form>
	<?php
} else {
	if(isset($data['successMsg'])) {
		echo $data['successMsg'];
	}
	?>
	<form method="POST" action="">
		Потребителско име:<br>
		<input type="text" name="username"><br>
		Парола:<br>
		<input type="password" name="password"><br>
		<input type="submit" name="submit" value="Регистрирай се!">
	</form>
	<?php
}
?>