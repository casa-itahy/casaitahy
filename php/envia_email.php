<?php

	@session_start();

	include_once('../admin/includes/db.php');
	require_once('plugins/PHPMailer/class.phpmailer.php');

	$retorno = query("SELECT * FROM config");

	extract($_POST);

	// Se nenhum valor foi recebido, o usuário não realizou o captcha
	if (empty($nome) || empty($email)) {
	    echo "Preencha todos os campos!";
		exit;
	}

	if ($resposta.success) {
		echo "";
	} else {
		echo "Usuário mal intencionado detectado. A mensagem não foi enviada.";
		exit;
	}

	/************************************** smtp **************************************/
	$smtp_para 		= $retorno[0]['emailC']; // Para onde vai o e-mail
	$smtp_host 		= $retorno[0]['smtp_host']; // Host do e-mail. EX.: smtp.dominio.com.br
	$smtp_user 		= $retorno[0]['smtp_email']; // E-mail que envia EX.: servidor@dominio.com.br
	$smtp_pass 		= $retorno[0]['smtp_pass']; // senha do e-mail que envia
	$smtp_site 		= 'Casa Itahy'; //$retorno[0]['titulo']; // Nome do site EX.: Art Web Digital
	$smtp_assunto 	= "Contato do Site " . $smtp_site; // Assunto do e-mail
	$smtp_resp 		= $retorno[0]['envio_resposta']; // Resposta que o usuário ira receber
	/************************************** smtp **************************************/

	$texto="Assunto: ".$assunto."<br />";
	$texto.="Nome: ".$nome."<br />";
	$texto.="E-mail: ".$email."<br />";
	$texto.="Mensagem: ".$mensagem."<br /><br />";

	$data = date("d/m/Y");
	$hora = date("H:i");

	$texto.="Data do envio: ".$data."\n";
	$texto.="Hora do envio: ".$hora."\n";

	if(!empty($_FILES["arquivo"])) { 
		// Recupera o nome do arquivo
		$arquivo    		= $_FILES["arquivo"];
		$arquivo_nome 		= $arquivo['name'];
		// Recupera o caminho temporario do arquivo no servidor
		$arquivo_caminho 	= $arquivo['tmp_name'];
	}
	  
	if(mb_detect_encoding($texto.'x', 'UTF-8, ISO-8859-1')=='UTF-8'){
		$texto = utf8_decode($texto);
	}
	if(mb_detect_encoding($smtp_assunto.'x', 'UTF-8, ISO-8859-1')=='UTF-8'){
		$smtp_assunto = utf8_decode($smtp_assunto);
	}
	if(mb_detect_encoding($smtp_site.'x', 'UTF-8, ISO-8859-1')=='UTF-8'){
		$smtp_site = utf8_decode($smtp_site);
	}

	$mailer = new PHPMailer();
	$mailer->IsSMTP();
	$mailer->SMTPDebug 	= 1;
	$mailer->Port 		= 587; 							
	$mailer->Host 		= $smtp_host;
	$mailer->SMTPAuth 	= true; 						
	$mailer->Username 	= $smtp_user; 	
	$mailer->Password 	= $smtp_pass;	
	$mailer->FromName 	= $smtp_site; 					
	$mailer->From 		= $smtp_user; 
	$mailer->AddReplyTo($email,$nome); 

	// Anexa o arquivo
	if(!empty($_FILES["arquivo"])) { 
		$mailer->AddAttachment($arquivo_caminho, $arquivo_nome);
	}

	$mailer->AddAddress($smtp_para,$smtp_site); 
	$mailer->IsHTML(true);
	$mailer->Subject = $smtp_assunto;
	$mailer->Body = $texto;

	if(!@$mailer->Send()){
	     $msg ='Não foi possível enviar este email!<br/>Por favor, tente outra hora, ou envie diretamente para '.$smtp_para; //.$mailer->ErrorInfo;
	     exit;
	}else{
	    if ($smtp_resp == null || $smtp_resp == '') {
	        $msg = "Sua mensagem foi encaminhada com sucesso!.";
	    } else {		
			$mailer2 = $mailer;
			$mailer2->ClearAddresses();
			$mailer2->AddAddress($email,$smtp_site);
			$mailer2->IsHTML(true);
			$mailer2->Subject = $smtp_assunto;
			$mailer2->AddReplyTo($smtp_para,$smtp_site); 
			$mailer2->clearAttachments();
			
			if (mb_detect_encoding($smtp_resp.'x', 'UTF-8, ISO-8859-1')=='UTF-8') {
				$smtp_resp = utf8_decode($smtp_resp);
			}
			
			$mailer2->Body = $smtp_resp;
			
			if (!@$mailer2->Send()) {
				$msg ='Não foi possível enviar este email!<br/>Por favor, tente outra hora, ou envie diretamente para '.$smtp_para; //.$mailer->ErrorInfo;    
				exit;
			} else {
				$msg = "Sua mensagem foi encaminhada com sucesso!";
			}
	    }
	}

	echo '<script>location.href="'.$link.'&msg='.$msg.'"</script>';