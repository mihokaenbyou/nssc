<?php 	
// connect to bdd
	try {
		// $bdd = new PDO('mysql:host=localhost;dbname=xxxx', 'xxxx', '');
		$bdd = new PDO('mysql:host=localhost;dbname=xxxx', 'xxxx', 'xxxx');
	}
	catch (Exception $e) {
	die('Error: ' . $e->getMessage());
	}	
?>
