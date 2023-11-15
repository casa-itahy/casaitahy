<?php
session_start();
if(!isset($_SESSION['cliente']['id'])) {
	//echo('<meta http-equiv="refresh" content="0;URL=home">');
	header("LOCATION: erro");
}else{
	$idLogado = $_SESSION['cliente']['id'];
}
?>