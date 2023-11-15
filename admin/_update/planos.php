<?php 
	include("../php/sessao.php");
        session_write_close();
	include("../includes/db.php");
	include ("../php/funcoes.php");

    extract($_POST);

    $sql = "UPDATE plano_individual SET
    solucao = '$solucao',
    titulo = '$titulo',
    valor1 = '$valor1',
    valor2 = '$valor2',
    valor3 = '$valor3',
    valor4 = '$valor4',
    valor5 = '$valor5',
    valor6 = '$valor6'
    WHERE id= ".$id;

    $conn = conecta();
	$q = @mysqli_query($conn, $sql);
	if($q == false){
                var_dump($sql);
                die();
		$msg = "Erro ao realizar a operação!";
	}else{		
		$msg = "Operaçao realizada com sucesso!";
	}
        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
if (!headers_sent($filename, $linenum)) {
    header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
    exit;
}
?>