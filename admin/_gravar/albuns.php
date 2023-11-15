<?php 

include("../includes/db.php");
include ("../php/funcoes.php");
include("../php/sessao.php");
include("../../php/plugins/seo.php");
session_write_close();

extract($_POST);
   
$modulo = query("SELECT modulo_gemeo FROM modulos WHERE pag_tab_id='".$pag."';");
$idiomas = query("SELECT * FROM idiomas");

/* Procura a ultima posição */
$posicao = ultimaPosicao($tabela);
$posicao = $posicao + 1;

$albun_id=0;
$erro=true;
foreach($idiomas as $idioma){
    $idioma_id = $idioma['id'];    
    $sigla = $idioma['sigla'];
    $titulo = $_POST['titulo'.$sigla];

	
    //$titulo = mysql_escape_string($titulo);    
	
	//link
	//verrificar se o link não ira ser duplicado
	$link = limpaURL($title);
    $verifica = query("SELECT * FROM links WHERE lin_nome = '$link'");
    
    //caso exista ja um link igual este, entao será adicionado a data do cadastro no final deste link, a data no formato dd-mm-yyyy !!!SEM AS BARAS!!!
    if(count($verifica) >0 ) {
    	$dia = date("d-m-i");
    	$link = $link."-".$dia;
    }

    // Gravando a data
    if (!empty($created)) {
        $created = explode('/', $created);
        $created = $created[2]."-".$created[1]."-".$created[0]." 00:00:00";
    } else {
        $created = date('Y-m-d H:i:s');
    }
	
    $conn = conecta(); 
    if(strtolower(trim($sigla))=='port'){        
			$sql="INSERT INTO $tabela (titulo, posicao, tipo, created, modified)VALUES('$titulo','$posicao', '$categoria','$created',NOW())";
            //var_dump($sql);die();
            $conn = conecta();
            $q = mysqli_query($conn, $sql);           
            $albun_id = ((is_null($___mysqli_res = mysqli_insert_id($conn))) ? false : $___mysqli_res);
			
			//link url
			$gravaLink = "INSERT INTO links (lin_pagina, lin_nome, title, metad, lin_id_pg, tipo) VALUES ('album', '$link', '$title', '$metad', '$albun_id', 5)";
			gravar($gravaLink);
			
    }else{
        if($albun_id!=0){
            $sql="INSERT INTO albuns_idioma(albuns_id,idioma_id,titulo)VALUES('$albun_id','$idioma_id','$titulo')";
            $q = mysqli_query($conn, $sql);
            if($q == false){
                $msg = "Erro ao realizar a operação! cod 3";
            }else{
                $msg = "Operação realizada com sucesso!";
            }
        }        
    }
}
@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);

if (!headers_sent($filename, $linenum)) {
    header('Location: ../index.php?pag='.$pag.'&tipo=e&id='.$albun_id.'&msg='.$msg);
    exit;
}

?>