<?php 
	include("../php/sessao.php");
        session_write_close();
	include("../includes/db.php");

extract($_POST);

$senha = sha1($senha);


$sql="INSERT INTO usuarios 
		(
		nome, 
		login,
		senha,
		nivel,
		created,
		modified
		)
		VALUES
		(
		'$nome', 
		'$login',
		'$senha',
		'$nivel',
		NOW(),
		NOW()
		)";

	$conn = conecta();
	$q = @mysqli_query($conn, $sql);
	if($q != false){
                $id_atual = ((is_null($___mysqli_res = mysqli_insert_id($conn))) ? false : $___mysqli_res);
                $sql = "SELECT id,descricao FROM modulos WHERE status=1 ";//AND pag_tab_nome!='usuarios' AND pag_tab_nome!='config'";
                $modulos = query($sql);                
                foreach($modulos as $item){
                    //Verifica se foi selecionado no checkbox
                    if($_POST[$item['id']]==1){
                        $sql="INSERT INTO usuarios_modulos(usuario_id,modulo_id)VALUES(".$id_atual.",".$item['id'].")";
                        $conn = conecta();
                        @mysqli_query($conn, $sql);
                     }
                }                
                $msg = "Operação realizada com sucesso!";
	}else{
            $msg = "Não foi possível inserir o usuario! Tente novamente ou comunique seu administrador.";
        }
@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
if (!headers_sent($filename, $linenum)) {
	header('Location: ../index.php?pag=7&tipo=p&msg='.$msg);
    exit;
}

?>