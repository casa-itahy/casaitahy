<?php 
include("../includes/db.php");
include ("../php/funcoes.php");
include("../php/imgCaminho.php");
include("../../php/plugins/seo.php");

extract($_POST);

$idiomas = query("SELECT * FROM idiomas WHERE status=1");
$modulo = query("SELECT orientacao, tam_principal, tam_thumb FROM modulos WHERE pag_tab_id='".$pag."';");

$imagemUP = $_FILES['imagem'];
if (count($imagemUP) != 0 ){
	if ($imagemUP['error'] == 0 ) {
		$imagem = gravaImagem($imagemUP, $tabela, $modulo['0']['tam_principal'], $modulo['0']['tam_thumb'], $modulo['0']['orientacao']);
		if (!$imagem) {
			$UPimagem = "";
		} else {
			$UPimagem = "imagem='$imagem', ";
		}
	}else{
		$UPimagem =' ';
	}
}

$imagemUP2 = $_FILES['imagem2'];
if (count($imagemUP2) != 0 ){
	if ($imagemUP2['error'] == 0 ) {
		$imagem = gravaImagem($imagemUP2, $tabela."/imagem2", $modulo['0']['tam_principal'], $modulo['0']['tam_thumb'], $modulo['0']['orientacao']);
		if (!$imagem) {
			$UPimagem2 = "";
		} else {
			$UPimagem2 = "menu_img='$imagem', ";
		}
	}else{
		$UPimagem2 =' ';
	}
}

/*if(isset($oldpai) && isset($pai)){
	if ($oldpai != $pai){		 
		$sql = "SELECT MAX(posicao) 
					FROM paginas p
					LEFT JOIN modulos m ON(p.tipo=m.id)
					LEFT JOIN pag_subpag_nivel psp ON(p.id=psp.pag_pai_id)
					WHERE psp.pag_pai_id='$pai' ";
		$retorno = query($sql);
		$posicao = $retorno[0]['MAX(posicao)'];
		$posicao = $posicao + 1;	
		//$inclusao = " idpai = '$pai', posicao = '$posicao',";
	}
}*/
$tipoD = $tipo;
if($tipo!='0'){
    $tipo="tipo='$tipo',";
}else{
    $tipo='';
}

if (isset($oldpai)) {
	$valores = explode('-',$oldpai);

	if($valores[1]){
		$oldpai = $valores[0];
		$oldfilho = $valores[1];
		if($valores[2]){
			$oldid=$valores[2];
			$oldneto=$valores[2];
		}else{
			$oldid=$valores[1];
			$oldneto='NULL';
		}
	}else{
		$oldpai = $valores[0];
		$oldid=$valores[0];
		$oldfilho='NULL';
		$oldneto='NULL';
	}

	if ($oldpai != $pai){
		$sql = "SELECT MAX(posicao)
					FROM paginas WHERE id='$pai' ";
		$retorno = query($sql);
		$posicao = $retorno[0]['MAX(posicao)'];
		$posicao = $posicao + 1;
		$inclusao = " idpai = '$pai', posicao = '$posicao',";
	}
	$valores = explode('-',$pai);

	if($valores[1]){
		$pai = $valores[0];
		$filho = $valores[1];
		if($valores[2]){
			$id=$valores[2];        
		}else{
			$id=$valores[1];        
		}
	}else{    
		$id=$pai;
		$filho='NULL';
	}
} else {
	$oldid = $id;
}

  //$mysqli = conectaMysqli();
  //AUTOTRANSATION
  //$mysqli->autocommit(FALSE);
  //$all_query_ok=true; // our control variable
  //$consulta = new MySQLDB();

  if($oldfilho=='NULL'){
    $oldfilho="pag_filho_id IS NULL";
  }else{
    $id_pagina=$oldfilho;
    $oldfilho="pag_filho_id='$oldfilho'";    
  }

  if($oldneto=='NULL'){
    $oldneto="AND pag_neto_id IS NULL";
  }else{
      $id_pagina=$oldneto;
    $oldneto='AND pag_neto_id='.$oldneto;
  }

//verrifica o tipo de link
	if($pai != 0) {
		$tipoLink = 1;	
	}else{
		$tipoLink = 2;
	}

$erro=true;


foreach($idiomas as $idioma){
    $idioma_id = $idioma['id'];
    $sigla = $idioma['sigla'];
    $titulo = addslashes($_POST['titulo'.$sigla]);
    $texto= $_POST['texto'.$sigla];
    $title= addslashes($_POST['title'.$sigla]);
    $metad= addslashes($_POST['metad'.$sigla]);
	
	
	//editando o caminho da imagem que foi add no editor
	

	
	$newTexto = addslashes($texto);
	
	//echo $newTexto;
	
	//echo $base;
	
	//exit();
	
	//verrificar se o link não ira ser duplicado
    $link = limpaURL($title);
    $verifica = query("SELECT * FROM links WHERE lin_nome = '$link' AND lin_id_pg <> $oldid");
    
    //caso exista ja um link igual este, entao será adicionado a data (dia e hora) do cadastro no final deste link
    if(count($verifica) >0 ) {
    	$dia 	= date("d-h-i");
    	$link 	= $link."-".$dia;
    }
	
    if(strtolower(trim($sigla))=='port'){

        $conn = conecta();
        $sql1 = "UPDATE paginas SET titulo='$titulo', subtitulo='$subtitulo', conteudo='$newTexto',title='$title',metad='$metad',".$UPimagem.$UPimagem2.$tipo." modified =NOW() WHERE id=$oldid ";
        $q = @mysqli_query($conn, $sql1);  
		
		$tipoPag = query("SELECT * FROM paginas WHERE id=$oldid");
		$tipoPag = $tipoPag[0]['tipo'];
		
		//pegando a pagina
		$nomePg = query("SELECT * FROM modulos WHERE id='".$tipoPag."';");
		$nmPagina = $nomePg[0]['pag_tab_nome'];

        //link url 
        $conn = conecta();
        $upLink = "UPDATE links SET lin_pagina='$nmPagina', title='$title', lin_nome='$link', metad='$metad' WHERE lin_id_pg = '$oldid' AND tipo <= 2";
        $q2 = @mysqli_query($conn, $upLink);
		      
    }else{
        $conn = conecta();
        
        $sql = "UPDATE conteudo_simples_idioma SET titulo='$titulo', conteudo='$newTexto',title='$title',metad='$metad' WHERE pagina_id=$oldid AND idioma_id=$idioma_id";;
        $q = @mysqli_query($conn, $sql);            
        //SE NÃO EXISTE DADOS DE IDIOMA NA TABELA, CRIAR: (sistemas antes deste código não inserem noticoas de idioma vazio)
        if(mysqli_affected_rows($conn)==0){
            $sql="INSERT INTO conteudo_simples_idioma(pagina_id,idioma_id,titulo,title,metad,conteudo)VALUES('$id','$idioma_id','$titulo','$title','$metad','$newTexto')";
            $p = @mysqli_query($conn, $sql);
        }
    }    
}
//var_dump('asdasd');die();
if($q != false){
      
      if($filho=='NULL'||empty($filho)){
            //ALTERA SOMENTE O PAI          
            if($id!=0){
                if($id_pagina=='') $id_pagina=$oldpai;
                $sql2="UPDATE pag_subpag_nivel SET pag_pai_id=$id, pag_filho_id=$id_pagina,pag_neto_id=NULL WHERE pag_pai_id='$oldpai' AND $oldfilho ".$oldneto.";";
            }else{
                if($id_pagina=='') $id_pagina=$oldid;
                $sql2="UPDATE pag_subpag_nivel SET pag_pai_id='$id_pagina',pag_filho_id=NULL,pag_neto_id=NULL WHERE pag_pai_id='$oldpai' AND $oldfilho ".$oldneto.";";
            }
      }else{//ALTERA PELA BUSCA
          if($oldneto!='NULL')
                $neto=$oldneto;

          $sql2="UPDATE pag_subpag_nivel SET pag_pai_id='$pai',pag_filho_id='$filho',pag_neto_id='$oldid' WHERE pag_pai_id='$oldpai' AND $oldfilho ".$oldneto.";";
      }
      $q = @mysqli_query($conn, $sql2);
  }
  @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);

if($q=='' || $q==true){
     $msg ="<p>Categoria alterada!</p>";     
}else{
    $msg ="<p>Não foi possível alterar o dados</p>
            <p>Caso continue o problema, comunique seu administrador.</p>".$q;
}

if($q=='' || $q==true){
    $volta_altera='&tipo=p';
    $msg = "Operação realizada com sucesso!";
}else{		
    $volta_altera='&tipo=e&id='.$id;
    $msg = "Erro ao realizar a operação!";
}
   
if (!headers_sent($filename, $linenum)) {
    header('Location: ../index.php?pag=1'.$volta_altera.'&msg='.$msg);
    exit;
}


?>