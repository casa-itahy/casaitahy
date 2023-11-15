<?php

	session_start();

	unset($_SESSION['nome_adm']);
	unset($_SESSION['id']);
	unset($_SESSION['pages']);

	// echo "<pre>";
	// var_dump($_SESSION);
	// echo "</pre>";

	// echo "Aqui";

	// exit;

	header("location: ../index.php");

?>