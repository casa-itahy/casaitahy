<?php 
	include("../php/sessao.php");
        session_write_close();
	include("../includes/db.php");
	include ("../php/funcoes.php");

extract($_POST);

if($id=='' || is_null($id) || strlen($senha)<6){
    $msg="Obrigatório senha maior que 6 caracteres.";
    if (!headers_sent($filename, $linenum)) {
	header('Location: ../index.php?pag=7&tipo=pass&id='.$id.'&msg='.$msg);
        exit;
    }
}else{
        $senha = sha1($senha);

        $sql = "UPDATE $tabela SET 
        senha='$senha',
        modified =NOW()
        WHERE id=$id ";


        $conn = conecta();
                $q = mysqli_query($conn, $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                if($q == false){ 
                        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 		
                        $msg = "Erro ao realizar a operação!";
                }else{
                        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
                        $msg = "Senha atualizada com sucesso!";
                }
}	

if (!headers_sent($filename, $linenum)) {
	header('Location: ../index.php?pag=7&tipo=p&msg='.$msg);
    exit;
}

?>