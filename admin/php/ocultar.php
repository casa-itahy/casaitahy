<?php 
include("../includes/db.php");
include("../php/sessao.php");


if(isset($_SESSION['id'])){        
    if($_SESSION['pag_id_atual']!='' && $_SESSION['pag_id_atual']!=0){
        $t=$_SESSION['pag_id_atual'];    
        session_write_close();
        $tabelas = query("SELECT pag_tab_nome FROM modulos WHERE pag_tab_id=".$t);
        $tabela = $tabelas[0]['pag_tab_nome'];

        @session_write_close();
        $id=$_POST['id'];
        if(isset($_POST['img_albuns'])){
            $tabela='img_pasta_albuns';
        }        
        $dados = query("SELECT status FROM ".$tabela." WHERE id='".$id."'");
        //var_dump($_POST);die();

            if($dados[0]['status']==0){
                $v=1;    
            }else{
                $v=0;
            }
            $sql = "UPDATE $tabela SET status=$v WHERE id=$id";

            $conn = conecta();
            $q = mysqli_query($conn, $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            if($q == false){ 
                    @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
                    $res = 'Erro: '.mysqli_error($GLOBALS["___mysqli_ston"]);		
            }else{
                    @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);		
                    $res=$id;
            }

            //header("location:../index.php?pag=".$t."&tipo=p");
            echo $res;
    }else{
        header("location:../index.php");
    }
}else{
    header("location:../index.php");
}
?>