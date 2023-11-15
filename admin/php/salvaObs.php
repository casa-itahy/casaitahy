<?php
 include_once('../includes/db.php');

 $idiomas = query("SELECT * FROM idiomas");
 
    $prod_id = $_POST['produto'];
    $kit_id = $_POST['kit'];
    $bloco_id = $_POST['bloco'];
    $nome = $_POST['observacao'];
    $tipo = 4;

     //BUSCA SE EXISTE KIT PARA CADA PRODUTO E KIT
    $sql = "SELECT * FROM kit_prod_bloco WHERE produto_id=$prod_id AND kit_id=$kit_id AND bloco_id=$bloco_id ORDER BY ordem";
    $itens_kit = query($sql);

    if(count($itens_kit)<1){
            /*//VERIFICA SE EXITE UM NOME SIMPLES DO PRODUTO
            $sql = "SELECT prod_nome_simples FROM kit_prod_bloco WHERE produto_id=$prod_id LIMIT 1";
            $prod_nome_simples = query($sql);
            if(count($prod_nome_simples)>0){
                $sql="INSERT INTO kit_prod_bloco(produto_id,kit_id,bloco_id,prod_nome_simples)VALUES('$prod_id','$kit_id','$bloco_id','".$prod_nome_simples[0]['prod_nome_simples']."');";
            }else{*/
                //SENÃO INSERE OS DADOS DE PRODUTOxKITxBLOCO
                $sql="INSERT INTO kit_prod_bloco(produto_id,kit_id,bloco_id)VALUES('$prod_id','$kit_id','$bloco_id');";
            //}
            $conn = conecta();
            $q = @mysqli_query($conn, $sql);
            @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
    }
  
    if($tipo==4){
        $sql = "UPDATE kit_prod_bloco SET observacao='$nome' WHERE produto_id='$prod_id' AND kit_id='$kit_id'";
    }
    $conn = conecta();
    $q = mysqli_query($conn, $sql);
    @((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
    if(count($idiomas)>0){
        foreach($idiomas as $idioma){
            $idioma_id = $idioma['id'];
            $sigla = $idioma['sigla'];
            $obs = $_POST['observacao'.$sigla];

            $sql = "UPDATE kit_prod_bloco_idioma SET observacao='$obs' WHERE produto_id='$prod_id' AND kit_id='$kit_id' AND idioma_id='$idioma_id'";
            $conn = conecta();          
            $q = mysqli_query($conn, $sql);            
            if(mysqli_affected_rows($conn)==0){
                @((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
                $sql = "SELECT idioma_id FROM kit_prod_bloco_idioma WHERE produto_id=$prod_id AND kit_id=$kit_id AND bloco_id=$bloco_id AND idioma_id=$idioma_id";
                $itens_kit_prod = query($sql);
                if(count($itens_kit_prod)<1){                    
                    $sql="INSERT INTO kit_prod_bloco_idioma(produto_id,kit_id,bloco_id,idioma_id,observacao)VALUES('$prod_id','$kit_id','$bloco_id','$obs');";
                    $conn = conecta();
                    $q = mysqli_query($conn, $sql);
                    @((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
                }
            }

        }
    }
        
    echo "<p style='color:red;'>Observação salva com sucesso!</p>";

?>
