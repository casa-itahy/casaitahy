<?php 

	include("sessao.php");
	include("../includes/db.php");

	$sql = "SELECT nome,email FROM clientes ORDER BY created";
	$dados = query($sql);
	$grava = "Nome;E-mail;\n";
	foreach ($dados as $linha){
		$grava .=$linha['nome'].";".$linha['email'].";\n";
	
	}

	$fp = fopen("../emails/emails.csv", "w");
	fwrite($fp, $grava);
	fclose($fp);

	echo "<a href='emails/emails.csv'>Clique aqui para baixar</a> ";

?>