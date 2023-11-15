<?php 
include("../includes/db.php");
include("../php/sessao.php");



if(isset($_SESSION['id'])){        
    if($_SESSION['pag_id_atual']!='' && $_SESSION['pag_id_atual']!=0){
        $tabelas = query("SELECT pag_tab_nome FROM modulos WHERE pag_tab_id=".$_SESSION['pag_id_atual']);
        $tabela = $tabelas[0]['pag_tab_nome'];
        $t=$_SESSION['pag_id_atual'];    

        @session_write_close();
        $id=$_POST['id'];
        
            $sql = "DELETE FROM ".$tabela." WHERE id='".$id."'";

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