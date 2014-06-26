<?php
include 'iWriter.php';

class Article {
	
	
	public function write(iWriter $obj) {
		$result = $obj->create();
		echo $result;
	}

}

include 'PdfWriter.php';
$writer = new PdfWriter();

$article = new Article();
$article->write($writer);