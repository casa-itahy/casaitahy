<?php

    include("../php/sessao.php");
    session_write_close();
    include("../includes/db.php");

    $id = $_GET['id'];
    $pasta = $_GET['pasta'];
    $pag = $_GET['pag'];

    $dados = query("SELECT menu_img FROM $pasta WHERE id = ".$id);

    $sql = "UPDATE $pasta SET menu_img='' WHERE id=$id ";
    	$conn = conecta();
    	$q = @mysqli_query($conn, $sql);	
            @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
            
    $caminho = "../imagens/".$pasta."/imagem2/".$dados[0]['menu_img'];
    if (file_exists($caminho)){	
                unlink ($caminho);
    }
    $caminho = "../imagens/".$pasta."/imagem2/thumb_".$dados[0]['menu_img'];
    if (file_exists($caminho)) {
    	unlink ($caminho);
    }

    header("location:../index.php?pag=".$pag."&tipo=e&id=".$id." ");