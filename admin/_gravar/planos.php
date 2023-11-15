<?php 

	include_once("../php/sessao.php");
        session_write_close();
	include_once("../includes/db.php");
	include_once ("../php/funcoes.php");

	extract($_POST);

	$posicao = ultimaPosicao($tabela);
	$posicao = $posicao + 1;

	$sql="INSERT INTO $tabela (
                solucao, titulo, valor1, valor2, valor3, valor4, valor5, valor6, posicao
		) VALUES (
				'$solucao', '$titulo', '$valor1', '$valor2', '$valor3', '$valor4', '$valor5', '$valor6', '$posicao'
		)";

	$conn = conecta();
	$q = mysqli_query($conn, $sql);        

	if($q == false)		
		$msg = "Erro ao realizar a operação!";
	else
		$msg = "Plano cadastrado com sucesso!";

    @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);

	if (!headers_sent($filename, $linenum)) {
		header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
	    exit;
	}

?>