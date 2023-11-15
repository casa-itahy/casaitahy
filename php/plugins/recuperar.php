<?php

	include("../../admin/includes/db.php");
	include 'functions.php';
	require_once('PHPMailer/class.phpmailer.php');
		

	
	$email = anti_sql($_POST['email']);

if (isset($email)) {
	
	$idTroca =  md5(uniqid(rand(), true));
	
	$cliente = query("SELECT id, nome, email FROM clientes WHERE email = '".$email."'");
	
	if (count($cliente) > 0) {
		
		$sql= "UPDATE clientes SET id_troca = '".$idTroca."' WHERE id='".$cliente['0']['id']."'";
		$q = gravar($sql);
		
		$sql = "SELECT * FROM config";
		$config = query($sql);
		
		$assunto = "Solicitação de troca de senha.";

		$link = "http://".$_SERVER['HTTP_HOST']."/novasenha&id=".$cliente['0']['id']."&key=".$idTroca;
		
		$texto = "
			Olá, ".$cliente['0']['nome']." <br/>
			<br/>
			Esta é uma solicitação de troca de senha do site ".$config['0']['titulo'].",
			para receber uma nova senha por email, favor clicar no link abaixo <br/>
			<br/>
			<a href='".$link."'>
				".$link."
			</a>
			<br/>
			<br/>
			<br/>
			Caso você não tenha feito essa solicitação, favor desconsiderar este email!
			<br/>
			<br/>
			<br/>

			".$config['0']['titulo']."
		";
		
		# Enviar link por email #
		$mailer = new PHPMailer();
		$mailer->IsSMTP();
		$mailer->CharSet	= 'utf-8';
		$mailer->SMTPDebug 	= 1;
		$mailer->Port 		= 587;
		$mailer->Host 		= $config['0']['smtp_host'];
		$mailer->SMTPAuth 	= true;
		$mailer->Username 	= $config['0']['smtp_email'];
		$mailer->Password 	= $config['0']['smtp_pass'];
		$mailer->FromName 	= $assunto;
		$mailer->From 		= $config['0']['smtp_email'];
		
		$mailer->AddAddress($cliente['0']['email'],$config['0']['titulo']); 
		$mailer->IsHTML(true);
		$mailer->Subject = $assunto;
		$mailer->Body = $texto;
		
		if(!$mailer->Send()){
		     echo 'Não foi possível enviar o email!';
		     exit;
		} else {
			echo "Você receberá um email com os passos para troca da senha!";
		}
		
		
	} else {		
		echo "Email não encontrado em nossa base de dados!";
	}
	
} else {		
	echo "Email não encontrado em nossa base de dados!";
}

?>