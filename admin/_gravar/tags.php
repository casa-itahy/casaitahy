<?php 

	include("../includes/db.php");

	extract($_POST);

	$tags = explode("\n", $tags);

    $conn = conecta();

    foreach ($tags as $tag) {
    	$tag = trim($tag);
		$sql="INSERT INTO tags (texto_tag)
					VALUES ('$tag')";

		$q = mysqli_query($conn, $sql);
    }

	if($erro == false){ 
	        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
	        $msg = "Erro ao realizar a operacão!";
	}else{
	        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
	        $msg = "Operação realizada com sucesso!";
	}

	if (!headers_sent($filename, $linenum)) {
		header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
	    exit;
	}