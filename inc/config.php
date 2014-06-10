<?php 	
// connect to bdd
	try {
		// $bdd = new PDO('mysql:host=localhost;dbname=fuyuneko', 'root', '');
		$bdd = new PDO('mysql:host=localhost;dbname=vulcania', 'vulcania', '1337');
	}
	catch (Exception $e) {
	die('Error: ' . $e->getMessage());
	}	
?>