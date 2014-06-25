<?php
if (!empty($data['errors'])) {
	echo '<ul>';
	foreach ($data['errors'] as $error) {
		echo '<li>' . $error . '</li>';
	}
	echo '</ul>';
	?>
	<form method="POST" action="" enctype="multipart/form-data">
		Заглавие:<br>
		<input type="text" name="news_title" value="<?php echo $data['news_data']['title']; //Поставяме изпратените от формата данни, за да не ги пише отново потребителя, ако има грешка    ?>"><br>
		Категория: <select name="news_cat">
			<?php
			foreach ($data['categories'] as $key => $category) {
				$selected = '';
				if ($key == $data['news_data']['cat']) {
					$selected = 'selected';
				}
				echo '<option value="' . $key . '" ' . $selected . '>' . $category . '</option>';
			}
			?>
		</select><br>
		Снимка: <input type="file" name="news_photo"><br>
		Описание на новината:<br>
		<textarea name="news_content"><?php echo $data['news_data']['title']; ?></textarea><br>
		<input type="submit" name="submit" value="Добави новина!">
	</form>
	<?php
} else {
	if (isset($data['successMsg'])) {
		echo $data['successMsg'];
	} else {
		?>
		<form method="POST" action="" enctype="multipart/form-data">
			Заглавие:<br>
			<input type="text" name="news_title"><br>
			Категория: <select name="news_cat">
				<?php
				foreach ($data['categories'] as $key => $category) {
					echo '<option value="' . $key . '">' . $category . '</option>';
				}
				?>
			</select><br>
			Снимка: <input type="file" name="news_photo"><br>
			Описание на новината:<br>
			<textarea name="news_content"></textarea><br>
			<input type="submit" name="submit" value="Добави новина!">
		</form>
		<?php
	}
}
?>