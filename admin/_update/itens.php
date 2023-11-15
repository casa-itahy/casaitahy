<?php 
include("../php/sessao.php");
include("../includes/db.php");
include ("../php/funcoes.php");

if($_SESSION['pag_atual_nome']!='itens'){
    session_write_close();
    header('Location: ../index.php');
    exit;
}else{
$pag_atual_id=$_SESSION['pag_atual_id'];
session_write_close();
extract($_POST);

$idiomas = query("SELECT * FROM idiomas WHERE status=1");

foreach($idiomas as $idioma){
    $idioma_id = $idioma['id'];
    $sigla = $idioma['sigla'];
    $descricao = $_POST['nome'.$sigla];

    $conn = conecta();
    if(strtolower(trim($sigla))=='port'){   
         $sql = "UPDATE itens SET cod='$cod', descricao='$descricao' WHERE id=".$id;
         $q = mysqli_query($conn, $sql);
    }else{
        $sql="UPDATE itens_idioma SET descricao='$descricao' WHERE itens_id=$id AND idioma_id=$idioma_id";
        $q = mysqli_query($conn, $sql);
        if(mysqli_affected_rows($conn)==0){
            $sql="INSERT INTO itens_idioma(itens_id,idioma_id,descricao)VALUES('$id','$idioma_id','$descricao')";
            $q = mysqli_query($conn, $sql);
        }
    }
}

if($q == false){            
        $msg = "Não foi posível realizar a operação!";
}else{
        $msg = "Operaçao realizada com sucesso!";
}

@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
if (!headers_sent($filename, $linenum)) {
    header('Location: ../index.php?pag='.$pag_atual_id.'&tipo=p&msg='.$msg);
    exit;
}
}
?>