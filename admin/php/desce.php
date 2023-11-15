<?php 
include_once("../php/funcoes.php");
include_once("../includes/db.php");
$t = $_GET[t];

	//voltar sem perder filtros ....
	if(isset($_GET['lista'])) {
		$getLista = $_GET['lista'];
	}
	
	if(isset($_GET['o'])) {
		$geto = $_GET['o'];
	}
	
	if(isset($_GET['buscar'])) {
		$getBuscar = $_GET['buscar'];
	}

include_once("../php/sessao.php");
$tabela = $_SESSION['pages'][$t]['pag_tab_nome'];
session_write_close();


$id = $_GET[id];

       if($tabela=='produtos'){
            $cat_id=' categoria_id,';            
        }else{
            $cat_id='';            
        }

	$sql = "SELECT ".$cat_id." posicao FROM $tabela WHERE id=$id";
	$dados = query($sql);
	$atual = $dados[0][posicao];	
	
	$ultimo = ultimaPosicao($tabela);

	if ($atual != $ultimo){
                if($tabela=='produtos'){                    
                        $cat_where = ' AND categoria_id='.$dados[0]['categoria_id'].' ';
                }else{
                        $cat_where = '';
                }
                 
                $sql1 = "SELECT id, posicao FROM $tabela WHERE posicao > ".$atual." ".$cat_where;
                $existe_produto_maior = query($sql1);
                
                if (count($existe_produto_maior)>0){
                        $flag = false;
                        $i=1;	
                        while ($flag == false){
                            $anterior = $atual + $i;
                            $sql = "SELECT id, posicao FROM $tabela WHERE posicao = $anterior"." ".$cat_where;                            
                            $dados = query($sql);

                            if (count($dados)>0){
                                    $flag = true;
                            }
                            $i = $i + 1;
                        }
                        $idAnterior = $dados[0][id];

                        $sql = "UPDATE $tabela SET posicao=$anterior WHERE id=$id ";
                        $conn = conecta();
                        $q = mysqli_query($conn, $sql);
                        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);

                        $sql = "UPDATE $tabela SET posicao=$atual WHERE id=$idAnterior ";
                        $conn = conecta();
                        $q = mysqli_query($conn, $sql);
                        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
                }
	}
header("location:../index.php?pag=".$t."&lista=".$getLista."&o=".$geto."&buscar=".$getBuscar."&tipo=p");

?>