<?php 
include("../php/funcoes.php");
include("../includes/db.php");

$id = $_GET[id];
$prod_id = $_GET[prod_id];
$sentido = $_GET[sentido];
$t = $_GET[tab];
$pag = $_GET[pag];



switch($t) {
	case 'prod':
	$tabela = "img_pasta_prod";
            $campo_id="produto_id";
            $pag.='&tipo=e';
	break;
	
	case 'album':
	$tabela = "img_pasta_albuns";
            $campo_id="albuns_id";
            $pag.='&tipo=e';//$pag='41';
	break;
}
	$sql = "SELECT posicao FROM $tabela WHERE id=$id";        
	$dados = query($sql);
	$atual = $dados[0][posicao];

          //var_dump($atual,$id);
            //        die();
if($sentido=='s'){
	$primeiro = primeiraPosicao($tabela);
        //var_dump($atual,$primeiro);
        //die();
	if ($atual != $primeiro){	
		$flag = false;
		$i=1;		
		//PERCORRE A TABELA(DIMINUINDO OS IDS) ATÉ ACHAR O ITEM ANTERIOR
                while ($flag == false){
			$anterior = $atual - $i;
			$sql = "SELECT id, posicao FROM $tabela WHERE posicao = $anterior AND ".$campo_id."=$prod_id";                        
			$dados = query($sql);
			if (count($dados)>0){
                            $flag = true;
			}
			$i = $i + 1;
		}
                if($flag){
                    $idAnterior = $dados[0][id];
                    $sql = "UPDATE $tabela SET posicao=$anterior WHERE id=$id ";
                    $conn = conecta();
                    $q = @mysqli_query($conn, $sql);
                    if($q == false){
                        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);                      
                    }
                
                    $sql = "UPDATE $tabela SET posicao=$atual WHERE id=$idAnterior ";
                    $conn = conecta();
                    $q = @mysqli_query($conn, $sql);
                    if($q == false){
                        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);                        
                    }
                }
	}
}else{
    if($sentido=='d'){
        $ultimo = ultimaPosicao($tabela);
	if ($atual != $ultimo){
		$flag = false;
		$i=1;
		while ($flag == false){
			$anterior = $atual + $i;
			$sql = "SELECT id, posicao FROM $tabela WHERE posicao = $anterior AND ".$campo_id."= $prod_id";
			$dados = query($sql);
			if (count($dados)>0){
				$flag = true;
			}
			$i = $i + 1;
		}
                if($flag){
                    $idAnterior = $dados[0][id];
                    $sql = "UPDATE $tabela SET posicao=$anterior WHERE id=$id ";
                    $conn = conecta();
                    $q = @mysqli_query($conn, $sql);
                    if($q == false){
                        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
                    }
                    $sql = "UPDATE $tabela SET posicao=$atual WHERE id=$idAnterior ";
                    $conn = conecta();
                    $q = @mysqli_query($conn, $sql);
                    if($q == false){
                        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
                    }
                }
       }
    }
}
header("Location:../index.php?pag=".$pag."&id=".$prod_id);

?>