<?php 
	include("../php/sessao.php");
	include("../includes/db.php");

if($_SESSION['pag_atual_nome']!='itens'){
    session_write_close();
    header('Location: ../index.php');
    exit;
}else{
     $pag_id=$_SESSION['pag_atual_id'];
    session_write_close();
    extract($_POST);

    $idiomas = query("SELECT * FROM idiomas WHERE status=1");
    
    $item_id=0;
    $erro=true;
    foreach($idiomas as $idioma){
        $idioma_id = $idioma['id'];
        $sigla = $idioma['sigla'];
        $nome = $_POST['nome'.$sigla];

        $conn = conecta();

        if(strtolower(trim($sigla))=='port'){                            
                    $sql="INSERT INTO itens(cod,descricao) VALUES('$cod','$nome')";
                    $q = mysqli_query($conn, $sql);
                    $item_id = ((is_null($___mysqli_res = mysqli_insert_id($conn))) ? false : $___mysqli_res);                    
                    //var_dump($sql); die();
        }else{
            if($item_id!=0){
                $sql="INSERT INTO itens_idioma(itens_id,idioma_id,descricao)VALUES($item_id,$idioma_id,'$nome')";
                $q = mysqli_query($conn, $sql);
                //var_dump($sql); die();
            }
        }
    }
    
    if($q==false){
        $msg = "Não foi possível inserir o dado!";
    }else{
        $msg = "Operação realizada com sucesso!";
    }
    @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);

   

    if (!headers_sent($filename, $linenum)) {
            header('Location: ../index.php?pag='.$pag_id.'&tipo=p&msg='.$msg);
        exit;
    }
}
?>