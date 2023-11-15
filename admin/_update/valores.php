<?php 

	include("../php/sessao.php");
        session_write_close();
	include("../includes/db.php");
	include ("../php/funcoes.php");

    extract($_POST);

    $valor_1 = str_replace(',', '.', $valor_1);
    $valor_2 = str_replace(',', '.', $valor_2);
    $valor_3 = str_replace(',', '.', $valor_3);
    $valor_4 = str_replace(',', '.', $valor_4);
    $valor_5 = str_replace(',', '.', $valor_5);
    $valor_6 = str_replace(',', '.', $valor_6);
    $valor_7 = str_replace(',', '.', $valor_7);
    $valor_8 = str_replace(',', '.', $valor_8);
    $valor_9 = str_replace(',', '.', $valor_9);
    $valor_10 = str_replace(',', '.', $valor_10);
    $valor_11 = str_replace(',', '.', $valor_11);

    $conn = conecta();

    $sql = "UPDATE valores SET valor = '".$valor_1."' WHERE id = 1";
	$q = @mysqli_query($conn, $sql);

    $sql = "UPDATE valores SET valor = '".$valor_2."' WHERE id = 2";
    $q = @mysqli_query($conn, $sql);

    $sql = "UPDATE valores SET valor = '".$valor_3."' WHERE id = 3";
    $q = @mysqli_query($conn, $sql);

    $sql = "UPDATE valores SET valor = '".$valor_4."' WHERE id = 4";
    $q = @mysqli_query($conn, $sql);

    $sql = "UPDATE valores SET valor = '".$valor_5."' WHERE id = 5";
    $q = @mysqli_query($conn, $sql);

    $sql = "UPDATE valores SET valor = '".$valor_6."' WHERE id = 6";
    $q = @mysqli_query($conn, $sql);

    $sql = "UPDATE valores SET valor = '".$valor_7."' WHERE id = 7";
    $q = @mysqli_query($conn, $sql);

    $sql = "UPDATE valores SET valor = '".$valor_8."' WHERE id = 8";
    $q = @mysqli_query($conn, $sql);

    $sql = "UPDATE valores SET valor = '".$valor_9."' WHERE id = 9";
    $q = @mysqli_query($conn, $sql);

    $sql = "UPDATE valores SET valor = '".$valor_10."' WHERE id = 10";
    $q = @mysqli_query($conn, $sql);

    $sql = "UPDATE valores SET valor = '".$valor_11."' WHERE id = 11";
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
        header('Location: ../index.php?pag=42&tipo=p&msg='.$msg);
        exit;
    }