<?php
session_start();

	include_once('../../admin/includes/db.php');
	include_once("functions.php");
	include_once("seo.php");	
	include_once('../ControlePrincipal.class.php');

	if(isset($_GET['idProd'])) {
		$proId = $_GET['idProd'];
		
		if(!is_numeric($proId) or !is_numeric($_GET['novQtd']) or $_GET['novQtd'] < 0)	{
			header("location: ../../index.php");
		}else{
			
			$chamaProduto = "SELECT * FROM produtos WHERE id = ".$proId;
			$mostraProduto = query($chamaProduto);
			$mostraProduto = $mostraProduto[0];
			
			$valor = str_replace('.' , '', $mostraProduto['valor']);
			
			$antigaQnt 	= $_GET['antQtd'];
			$novaQnt 	= $_GET['novQtd'];
			
			$valorTotalProdutoId = $antigaQnt * $valor;
			$novoValorTotal = $novaQnt * $valor;
			
			if($novaQnt == 0) {
				$_SESSION['produtosArtWebValor']['Total'] -= $valorTotalProdutoId;
				unset($_SESSION['produtosArtWeb']['produtos_'.$proId.'']);
			}else{
			
				$_SESSION['produtosArtWebValor']['Total'] -= $valorTotalProdutoId;
				
				unset($_SESSION['produtosArtWeb']['produtos_'.$proId.'']);
				
				
				$_SESSION['produtosArtWeb']['produtos_'.$proId.''] = $novaQnt;
				$_SESSION['produtosArtWebValor']['Total'] += $novoValorTotal;
			}
			
			if(count($_SESSION['produtosArtWeb']) == 0) {
				unset($_SESSION['produtosArtWeb']);
			}
			
			
			if(isset($_GET['pag']) and $_GET['pag'] == 'carrinho') {
				header("location: ../../carrinhoNlogado");
			}else{
				header("location: ../../carrinhoNlogado");	
			}
				
		}
	}

?>