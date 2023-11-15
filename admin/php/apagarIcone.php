<?php

    include("../php/sessao.php");
    session_write_close();
    include("../includes/db.php");

    $id = $_GET['id'];
    $pasta = $_GET['pasta'];
    $pag = $_GET['pag'];
    $tab=$pasta;

    $sql = "SELECT icone FROM $tab WHERE id=$id ";
    $dados = query($sql);

    $sql = "UPDATE $tab SET icone='' WHERE id=$id ";
    	$conn = conecta();
    	$q = @mysqli_query($conn, $sql);	
            @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
        
    $caminho = "../imagens/".$pasta."/icones/".$dados[0]['icone'];
    if (file_exists($caminho)){	
                unlink ($caminho);
    }
    $caminho = "../imagens/".$pasta."/icones/thumb_".$dados[0]['icone'];
    if (file_exists($caminho)) {
    	unlink ($caminho);
    }

    header("location:../index.php?pag=".$pag."&tipo=e&id=".$id." ");