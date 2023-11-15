<?php
//include("../php/funcoes.php");
include_once("../includes/db.php");
include_once("../includes/MySQLDB.php");

$t = $_GET[t];
$pai = false;
$filho = false;
$neto=false;

$valores = explode('-',$_GET[id]);
if($valores[1]){
    if($valores[2]){
        $id=$valores[2];
        $neto=true;
        $filho_id=$valores[1];
        $pai_id=$valores[0];
    }else{
        $id=$valores[1];
        $filho=true;
        $pai_id=$valores[0];
    }
}else{
    $id=$valores[0];
    $pai=true;
}

$tabela = 'categorias_subcat';
$sql = "SELECT posicao FROM $tabela WHERE id=$id";

$dados = query($sql);

$posicaoAtual = $dados[0][posicao];
$flag = false;
$i=1;

if($pai){
    $sql = "SELECT MAX(c.posicao) as posicao FROM categorias_subcat c
                    LEFT JOIN cat_subcat_nivel csn ON(c.id=csn.cat_filho_id)
                    WHERE csn.cat_filho_id IS NULL AND csn.cat_neto_id IS NULL ";

    $dados = query($sql);
    $primeiro = $dados[0]['posicao'];

    
    if($primeiro>$posicaoAtual){
    //DESCOBRE A POSICAO DA CATEGORIA PAI ANTES DA ATUAL
        while ($flag == false){
            $proximaPosicao= $posicaoAtual + $i;
            $sql ="SELECT csn.cat_pai_id, csn.cat_filho_id, c.posicao, c.id
                        FROM categorias_subcat c
                        INNER JOIN cat_subcat_nivel csn ON(c.id=csn.cat_pai_id)
                        WHERE c.posicao = '$proximaPosicao' AND csn.cat_filho_id IS NULL AND csn.cat_neto_id IS NULL";

            $dados = query($sql);

            if (count($dados)>0){
                    $flag = true;
            }
            $i = $i + 1;
        }
        //var_dump($primeiro,$posicaoAtual,$dados);
        //die();
    }
}else{
    if($filho){
        $sql = "SELECT MAX(c.posicao) as posicao FROM categorias_subcat c
                    LEFT JOIN cat_subcat_nivel csn ON(c.id=csn.cat_filho_id)
                    WHERE csn.cat_pai_id='$pai_id' AND csn.cat_neto_id IS NULL";

/*      var_dump($sql);
        die();*/
	$dados = query($sql);
	$primeiro = $dados[0]['posicao'];

  /*      var_dump($primeiro,$posicaoAtual,$dados);
        die();*/
        if($primeiro>$posicaoAtual){
            //DESCOBRE A POSICAO DA CATEGORIA FILHO ANTES DA ATUAL
            while ($flag == false){
                $proximaPosicao = $posicaoAtual + $i;

                $sql ="SELECT csn.cat_pai_id, csn.cat_filho_id, c.posicao, c.id
                        FROM categorias_subcat c
                        INNER JOIN cat_subcat_nivel csn ON(c.id=csn.cat_filho_id)
                        WHERE c.posicao = '$proximaPosicao' AND csn.cat_pai_id='$pai_id' AND csn.cat_neto_id IS NULL";

                $dados = query($sql);
                if (count($dados)>0){
                   $flag = true;
                }
                $i = $i + 1;
            }
        }
    }else{
        if($neto){
            $sql = "SELECT MAX(c.posicao) as posicao FROM categorias_subcat c
                    LEFT JOIN cat_subcat_nivel csn ON(c.id=csn.cat_neto_id)
                    WHERE csn.cat_pai_id='$pai_id' AND csn.cat_filho_id='$filho_id'";

            $dados = query($sql);
            $primeiro = $dados[0]['posicao'];

            if($primeiro>$posicaoAtual){
                //DESCOBRE A POSICAO DA CATEGORIA NETO ANTES DA ATUAL
                while ($flag == false){
                    $proximaPosicao = $posicaoAtual + $i;
                    $sql ="SELECT csn.cat_pai_id, csn.cat_filho_id, c.posicao, c.id
                            FROM categorias_subcat c
                            INNER JOIN cat_subcat_nivel csn ON(c.id=csn.cat_filho_id)
                            WHERE c.posicao = '$proximaPosicao' AND csn.cat_pai_id='$pai_id' AND csn.cat_filho_id='$filho_id'";

                    $dados = query($sql);
                    if (count($dados)>0){
                            $flag = true;
                    }
                    $i = $i + 1;
                }
            }
        }
    }
}
if($flag){
    $idAnterior = $dados[0]['id'];
    $consulta = new MySQLDB();

    $sql1 = "UPDATE $tabela SET posicao=$proximaPosicao WHERE id=$id";
    $sql2 = "UPDATE $tabela SET posicao=$posicaoAtual WHERE id=$idAnterior";

    $q = array (
     array("query" => $sql1),
     array("query" => $sql2),
    );

    $all_query_ok = $consulta->transaction($q);
}

if (!headers_sent($filename, $linenum)) {
   header('Location:../index.php?pag='.$t.'&tipo=p&msg='.$msg);
    exit;
}

?>