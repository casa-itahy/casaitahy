<?php

	include("../php/sessao.php");
	session_write_close();
	include("../includes/db.php");

	$id = $_GET['id'];
	$cliente = $_GET['cliente'];

	$sql = "SELECT cd.pasta,d.src FROM clientes_docs cd
	          LEFT JOIN docs as d ON(cd.docs_id=d.id)
	        WHERE docs_id=$id";
	$dados = query($sql);

	$conn = conecta();
	$sql = "DELETE FROM clientes_docs WHERE docs_id=$id";
	$q = @mysqli_query($conn, $sql);

	$conn = conecta();
	$sql = "DELETE FROM docs WHERE id=$id";
	$q = @mysqli_query($conn, $sql);

	@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);

	$caminho = "../docs_upload/".$dados[0]['pasta']."/".$dados[0]['src'];
	if (file_exists($caminho)){
		unlink ($caminho);
	}

	header("location:../index.php?pag=11&tipo=e&id=".$cliente."");

?>