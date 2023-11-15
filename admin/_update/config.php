<?php 
	include("../php/sessao.php");
        session_write_close();
	include("../includes/db.php");
	include ("../php/funcoes.php");

extract($_POST);

$sql ="SELECT * FROM config WHERE id='1'";
$res=query($sql);

$scripts = addslashes($scripts);
$scripts_body = addslashes($scripts_body);

if(count($res)>0){
    $sql = "UPDATE config SET
    titulo='$titulo',
    portal='$portal',
    www='$www',
    emailC='$emailC',
    descricao='$descricao',
    endereco='$enderecoC',
    horario='$horario',
    cep='$cep',
    cidade=$cidade,
    estado=$estado,
    fone1='$telefoneC',
    fone2='$celularC',
    fone3='$fone3',
    scripts='$scripts',
    scripts_body='$scripts_body',
    rede1='$rede1',
    rede2='$rede2',
    rede3='$rede3',
    rede4='$rede4',
    rede5='$rede5',
    rede6='$rede6',
    rodape='$rodape',
    smtp_host='$smtp_host',
    smtp_email='$smtp_email',
    smtp_pass='$smtp_pass',
    envio_resposta='$envio_resp',
    modified =NOW()
    WHERE id=1 ";
}

$conn = conecta();
	$q = @mysqli_query($conn, $sql);
	if($q == false){
                var_dump($sql);
                die();
		$msg = "Erro ao realizar a operação!";
	}else{		
		$msg = "Operaçao realizada com sucesso!";
	}
        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
if (!headers_sent($filename, $linenum)) {
    header('Location: ../index.php?pag=9&tipo=p&msg='.$msg);
    exit;
}
?>