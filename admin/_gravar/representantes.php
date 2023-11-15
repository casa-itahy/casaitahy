<?php 
	include_once("../php/sessao.php");
        session_write_close();
	include_once("../includes/db.php");
	include_once ("../php/funcoes.php");

extract($_POST);

$endereco = addslashes($endereco);

$sql="INSERT INTO associados (
			tipo,
			nome, 
			site,
			fone,
			fax,
			celular,
			email,
			endereco,
			cidade,
			estado,
			regiao,
			categoria,
			latitude,
			longitude,
			created,
			modified
		) VALUES (
			'2',
			'$nome',
			'$site', 
			'$telefone',
			'$fax',
			'$celular',
			'$email',
			'$endereco',
			'$cidade',
			'$estado',
			'$regiao',
			'$categoria',
			'$latitude',
			'$longitude',
			NOW(),
			NOW()
		)";

	$conn = conecta();
	$q = mysqli_query($conn,$sql);        
	if($q == false)		
		$msg = "Erro ao realizar a operação!";
	else
		$msg = "Credenciado cadastrado com sucesso!";

        @mysqli_close($conn);

if (!headers_sent($filename, $linenum)) {
	header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
    exit;
}

?>