<?php 
	include("../php/sessao.php");
        session_write_close();
	include("../includes/db.php");

$id = $_GET[id];
$t = $_GET[t];

switch($t) {
	case 1:
	$tabela = "paginas";
	break;
	
	case 2:
	$tabela = "categorias";
	break;
	
	case 3:
	$tabela = "produtos";
	break;
	
	case 4:
	$tabela = "albuns";
	break;
	
	case 5:
	$tabela = "noticias";
	break;
	
	case 7:
	$tabela = "usuarios";
	break;
}

$sql = "SELECT titulo FROM produtos WHERE idcategoria = $id ";
$retorno = query($sql);

if (count($retorno))
{
	$msg = "Erro ao excluir! <BR> Existem produtos nesta categoria, exclua-os primeiro!";
	header ("Location:../index.php?pag=".$t."&msg=".$msg." ");

}
else
{
	header ("Location:excluir.php?id=".$id."&t=".$t." ");
}

?>