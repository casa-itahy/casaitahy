<?php 
	include("../php/sessao.php");    
        session_write_close();

	include("../includes/db.php");

$t = $_GET[t];
$id = $_GET[id];
$v = $_GET[v];

	//voltar sem perder filtros ....
	if(isset($_GET['lista'])) {
		$getLista = $_GET['lista'];
	}
	
	if(isset($_GET['o'])) {
		$geto = $_GET['o'];
	}
	
	if(isset($_GET['buscar'])) {
		$getBuscar = $_GET['buscar'];
	}

switch($t) {
	case 1:
	$tabela = "paginas";
	break;
	
	case 2:
	$tabela = "categorias_subcat";
	break;
	
	case 3:
	$tabela = "produtos";
	break;
}

$sql = "UPDATE $tabela SET lancamento=$v WHERE id=$id ";
$conn = conecta();
$q = mysqli_query($conn, $sql);
if($q == false){ 
    @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
}

header("location:../index.php?pag=".$t."&lista=".$getLista."&o=".$geto."&buscar=".$getBuscar."&tipo=p");
exit();



?>