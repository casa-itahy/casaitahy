<?php 

    @session_start();
    $nivel = $_SESSION['nivel'];
    @session_write_close();

    include_once("../includes/db.php");

    $id = $_GET['id'];
    $t = $_GET['t'];

    if ($nivel==1){
        $tabela = 'categorias_noticias';

        $sql = "DELETE FROM $tabela WHERE id=$id ";            
        $conn = conecta();
        $q = @mysqli_query($conn,$sql);

        if(!$q){
                // @mysql_close($conn);                    
                $msg = "Erro ao realizar a operação!".$sql;
        }else{
                // @mysql_close($conn);
                $msg = "Operação realizada com sucesso!";
        }

    	echo('<meta http-equiv="refresh" content="0;URL=../index.php?pag='.$t.'&lista='.$getLista.'&o='.$geto.'&buscar='.$getBuscar.'&tipo=p&msg='.$msg.'">');
    }else{
    	$msg = "Somente usuário administrador pode excluir!";
    	echo('<meta http-equiv="refresh" content="0;URL=../index.php?pag='.$t.'&lista='.$getLista.'&o='.$geto.'&buscar='.$getBuscar.'&tipo=p&msg='.$msg.'">');
    }

?>