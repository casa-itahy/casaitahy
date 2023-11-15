<?php
 	include("../includes/db.php");
	include("usuario.php");
	
 $usuario = $_POST["usuario"];
 $senha = $_POST["senha"];
 $usuario = strtr($usuario, '\'', '*');
 $senha = strtr($senha, '\'', '*');
 
 $usuario = new Usuario($usuario,$senha);
 
 if ($usuario->autentica()){
	header("location:../index.php");
 }else{
	header("location:../index.php?pag=login");
 }
?>