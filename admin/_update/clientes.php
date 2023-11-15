<?php 
	include_once("../php/sessao.php");
        session_write_close();
	include_once("../includes/db.php");
	include_once("../php/funcoes.php");

extract($_POST);

if($pass!='' && $pass!=null)
    $senha= "senha ='".sha1($pass)."',";
else $senha='';

$sql = "UPDATE $tabela SET
nome='$nome',
login ='$login',
$senha
modified =NOW()
WHERE id=$id ";

$conn = conecta();
$q = @mysqli_query($conn, $sql);
if($q == false){ 
        $msg = "Não foi possível alterar os dados!".$sql;
}else{		
        $msg = "Dados atualizados com sucesso!";
}
@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);


header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
exit;


?>