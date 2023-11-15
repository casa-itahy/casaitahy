<?php
session_start();

	include_once('../../admin/includes/db.php');
	include_once("functions.php");
	include_once("seo.php");	
	include_once('../ControlePrincipal.class.php');

if(isset($_GET['proId'])) {
	
	$idProduto = $_GET['proId'];
	
	if(!is_numeric($idProduto)) {
		header("location: ../../index.php");	
	}else{
		
		$chamaProduto = "SELECT * FROM produtos WHERE id = ".$idProduto;
		$mostraProduto = query($chamaProduto);
		$mostraProduto = $mostraProduto[0];
		
		$valor = str_replace('.' , '', $mostraProduto['valor']);
		
		if(isset($_GET['delTotal']) and $_GET['delTotal'] == "nao") {
			
			$_SESSION['produtosArtWeb']['produtos_'.$idProduto.''] -= '1';
			$_SESSION['produtosArtWebValor']['Total'] -= $valor;
			
			if($_SESSION['produtosArtWeb']['produtos_'.$idProduto.''] <= 0) {
				unset($_SESSION['produtosArtWeb']['produtos_'.$idProduto.'']);
				if(count($_SESSION['produtosArtWeb']) <= 0) {
					unset($_SESSION['produtosArtWeb']);
					unset($_SESSION['produtosArtWebValor']);
				}
			}
				
		}elseif(isset($_GET['delTotal']) and $_GET['delTotal'] == "sim") {
			$totalProd = $_GET['total'];
			
			$totalDesconto = $totalProd * $valor;
			
			$_SESSION['produtosArtWebValor']['Total'] -= $totalDesconto;
			unset($_SESSION['produtosArtWeb']['produtos_'.$idProduto.'']);
			
			
			
		}
		
		if(count($_SESSION['produtosArtWeb']) == 0) {
			unset($_SESSION['produtosArtWeb']);
		}
		
		if(isset($_GET['pag']) and $_GET['pag'] == 'carrinho') {
			header("location: ../../carrinho/");
		}else{
			header("location: ../../index.php");	
		}
			
	}
}


?>