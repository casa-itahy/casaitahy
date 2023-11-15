<?php 
	include_once("../php/sessao.php");
        session_write_close();
	include_once("../includes/db.php");
	include_once ("../php/funcoes.php");

extract($_POST);

$dataAtual = date("d/m/Y");

$sql="INSERT INTO clientes (
		nome,
        login,
        senha,
		created,
		modified
	)VALUES(
		'$nome',
		'$login',
		'".sha1($pass)."',
		NOW(),
		NOW()
	)";


	$conn = conecta();
	$q = mysqli_query($conn, $sql);
        $ultimo_id = ((is_null($___mysqli_res = mysqli_insert_id($conn))) ? false : $___mysqli_res);
	if($q == false){
            $msg = "Erro ao realizar a operação!".$sql;            
            header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
        }else
            $msg = "Usuário cadastrado com sucesso!";

        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);

if(!headers_sent($filename, $linenum)){    
    header('Location: ../index.php?pag='.$pag.'&tipo=p');
    exit;
}

?>