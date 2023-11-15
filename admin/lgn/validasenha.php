<?php 

include("sessao.php");
include("../includes/db.php");

extract($_POST);

$senhaNew = sha1($senha);

$sql = "SELECT senha FROM usuarios WHERE id='$id'";
$dados = query($sql);
$senhaOld = $dados[0][senha];

if ($senhaNew != $senhaOld){
	echo "Senha não confere!";
}else{
	echo "<input name='senha' type='password' id='senha' size='20'  class='required validate-password' /><span class='valor_prod'> - Digite a nova senha.</span><br /><br />";
	echo "<input name='senhaC' type='password' id='senhaC' size='20' class='required validate-password-confirm' /><span class='valor_prod'> - Confirme a nova senha.</span><br><br>";
	echo "<input type='submit' value='Salvar'>";
}


?>