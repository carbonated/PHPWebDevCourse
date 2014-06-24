<?php
$title = 'Начало';
include './includes/header.php';
include './includes/menu.php';
?>
<div id="container">
	<h1 class="center-text">Начало:</h1>
	<hr>
	<?php
	$connection = mysqli_connect('localhost', 'root', '', 'news');
	if (!$connection) {
		exit;
	}
	mysqli_set_charset($connection, 'utf8');
	
	$query = mysqli_query($connection, "SELECT * FROM `news`");
	if(mysqli_num_rows($query) > 0) {
		while($row = mysqli_fetch_assoc($query)) {
			echo '<pre>'.print_r($row, true).'</pre>';
			echo '<img src="./uploads/'.$row['photo'].'">';
		}
	}
	?>
</div>
<?php
include './includes/footer.php';
?>