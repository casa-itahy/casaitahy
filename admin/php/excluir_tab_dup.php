<?php 

@session_start();
$nivel = $_SESSION['nivel'];
@session_write_close();

include_once("../includes/db.php");

$id = $_GET['id'];
$t = $_GET['t'];

if ($nivel==1){
#-------------------------------------------------------------------#

$sql='SELECT pag_tab_nome,id,modulo_gemeo FROM modulos WHERE pag_tab_id='.$t;
$pagina = query($sql);

$tabela = $pagina[0]['pag_tab_nome'];

switch($tabela) {
        case 'vendas': 
            $tabela='noticias';
            $tipo=$pagina[0]['modulo_gemeo'];
        break;
        case 'videos': 
            $tabela='noticias';
            $tipo=$pagina[0]['modulo_gemeo'];
        break;
        case 'empreparos ': 
            $tabela='noticias';
            $tipo=$pagina[0]['modulo_gemeo'];
        break;
        case 'premiacoes':
            $tabela='noticias';
            $tipo=$pagina[0]['modulo_gemeo'];
        break;
}
        $sql = "DELETE FROM $tabela WHERE id=$id AND tipo=$tipo";
        $conn = conecta();
        $q = @mysqli_query($conn, $sql);
        if(!$q){
                @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);                    
                $msg = "Erro ao realizar a operação!".$sql;
        }else{
                @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
                $msg = "Operação realizada com sucesso!";
        }
	
	header("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
}else{
	$msg = "Somente usuário administrador pode excluir!";
	header("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");        
}

?>