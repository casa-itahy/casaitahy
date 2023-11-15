<?php 

    include("../includes/db.php");
    include("../php/sessao.php");

    if(isset($_SESSION['id'])){        
        $id = $_GET['id'];
        $t = $_GET['t'];
        if(isset($_GET['img'])) {
            $existe_img = $_GET['img'];
        }

        $sql = "DELETE FROM tags WHERE id_tag=$id";
        $conn = conecta();
        $q = @mysqli_query($conn, $sql);
        if(!$q){
            @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);                    
            $msg = "Erro ao realizar a operação!".$sql;
        }else{
            @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
            $msg = "Operação realizada com sucesso!";
        }

        echo('<meta http-equiv="refresh" content="0;URL=../index.php?pag='.$t.'&tipo=p&msg='.$msg.'">');
    }else{
        header("location:../index.php");
    }