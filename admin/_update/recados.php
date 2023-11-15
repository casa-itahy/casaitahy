<?php 
	include("../php/sessao.php");
	include("../includes/db.php");
	include ("../php/funcoes.php");
        
extract($_POST);
//$titulo = mysql_escape_string($titulo);
//$texto_curto = mysql_escape_string($texto_curto);

$sql = "UPDATE recados SET 
titulo='$titulo',
recado='$texto_curto'
WHERE id=$id ";

    $conn = conecta();
    $q = mysqli_query($conn, $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    if($q == false){ 
            @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
            erro('
                    <p>Ocorreu um problema durante a grava��o no banco de dados mysql!</p>
                    <p>O erro encontrado foi:</p>
                    <p>'.mysqli_error($GLOBALS["___mysqli_ston"]).'</p>
            ');
            $msg = "Erro ao realizar a operação!";
    }else{
            @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
            $msg = "Operação realizada com sucesso!";
    }
 
if (!headers_sent($filename, $linenum)) {
	header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
    exit;
}	

?>