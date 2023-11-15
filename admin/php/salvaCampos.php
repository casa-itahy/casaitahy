<?php
 include_once('../includes/db.php');

    $prod_id = $_POST['prod_id'];
    $kit_id = $_POST['kit_id'];
    $bloco_id = $_POST['bloco_id'];
    $nome = $_POST['nome'];    
    $tipo = $_POST['tipo'];
    
    

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
    
    if(strlen($tipo)>1){
        ############ SE TEM MAIS DE1 CARACTER ENTÃO ESTA VINDO A SIGLA DO IDIOMA NO TEMOS Q SALVAR NA OURA TABELA ################
        $sql = "SELECT id FROM idiomas WHERE sigla='$tipo'";
        $idioma_sigla = query($sql);
        $tipo=$idioma_sigla[0]['id'];
        $conn = conecta();
        $sql = "UPDATE kit_prod_bloco_idioma SET prod_nome_simples='$nome' WHERE produto_id='$prod_id' AND kit_id='$kit_id' AND idioma_id='$tipo'";        
        $q = mysqli_query($conn, $sql);        
        //SE NÃO EXISTE DADOS DE IDIOMA NA TABELA, CRIAR:
        if(mysqli_affected_rows($conn)==0){
            @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
            ### SE EXISTE NA TABELA ### 
            $sql = "SELECT idioma_id FROM kit_prod_bloco_idioma WHERE produto_id='$prod_id' AND kit_id='$kit_id' AND idioma_id='$tipo'";
            $dados = query($sql);
            if(count($dados)<1){
                $conn = conecta();
                ### INSERE O NOVO REGISTRO #####
                $sql="INSERT INTO kit_prod_bloco_idioma(prod_nome_simples,idioma_id,produto_id,kit_id)VALUES('$nome','$tipo','$prod_id','$kit_id')";
                $q = mysqli_query($conn, $sql);
            }
        }
    }else{    
        if($tipo==1){
            $sql = "UPDATE kit_prod_bloco SET prod_nome_simples='$nome' WHERE produto_id='$prod_id' AND kit_id='$kit_id'";
        }else{
            if($tipo==2){
                if(trim($nome)=='vazio'){
                    $nome='';
                }
                $sql = "UPDATE kit_prod_bloco SET prefixo_kit_prod='$nome' WHERE produto_id='$prod_id' AND kit_id='$kit_id'";
            }else{
                if($tipo==3){                                
                    $sql = "UPDATE kit_prod_bloco SET permite_curso='$nome' WHERE produto_id='$prod_id' AND kit_id='$kit_id'";
                }else{               
                        if($tipo==4){
                            $sql = "UPDATE kit_prod_bloco SET obrigatorio_kit='$nome' WHERE produto_id='$prod_id' AND kit_id='$kit_id' AND bloco_id='$bloco_id'";
                        }else{                     
                            if($tipo==5){
                                $sql = "SELECT * FROM kit_prod_bloco WHERE produto_id=$prod_id AND kit_id=$kit_id AND bloco_id=$bloco_id AND ordem=$nome";
                                $res = query($sql);
                                if(count($res)>0){
                                    echo "<p style='color:red;'>A ordem digitada pra este bloco já existe!</p>";
                                    die();
                                }else{
                                    $sql = "UPDATE kit_prod_bloco SET ordem='$nome' WHERE produto_id='$prod_id' AND kit_id='$kit_id' AND bloco_id='$bloco_id'";
                                    //var_dump($sql);
                                    //die();
                                }
                            }
                        }
                    }
                }        
        }
        $conn = conecta();
        $q = mysqli_query($conn, $sql);
    }
    
    echo "<p style='color:red;'>Dados salvos automaticamente!</p>";

?>
