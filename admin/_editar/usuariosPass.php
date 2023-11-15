<?php 
		include("php/sessao.php");	
                session_write_close();

$id = $_GET['id'];

$sql = "SELECT * FROM usuarios	WHERE id=$id ";
$dados = query($sql);


?>

	<script type="text/javascript" src="js/validation.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css" />


<form action="_update/newSenha.php" enctype="multipart/form-data" method="post" id="form" name="form" >
<input type="hidden" id="tabela" name="tabela" value="usuarios" >
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" >
<table width="780" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><h1>Trocar Senha de Usu&aacute;rio</h1></td>
  </tr>  
  <tr>
    <td colspan="3" height="15" align="center"><p class="msg"><?php echo $_GET['msg']; ?></p></td>
  </tr>
  <tr>
    <td width="154" class="titulo_noticias">Nome Completo</td>
    <td colspan="2" class="titulo_noticias"><label>
      <?php echo $dados[0]['nome']; ?>
    </label></td>
  </tr>

  <tr>
    <td class="titulo_noticias">Login</td>
    <td width="163" class="titulo_noticias"><?php echo $dados[0]['login']; ?></td>
    <td width="443" class="valor_prod">&nbsp;</td>
  </tr>
  <tr> 	
    <td class="titulo_noticias">Digite a nova senha</td>
    <td class="titulo_noticias"><input name='senha' type='password' id='senha' size='20'  class='required validate-password' /></td>
  </tr>  
  <tr>
    <td class="titulo_noticias">&nbsp;</td>
    <td colspan="2" class="titulo_noticias">
            <input type='submit' value='Salvar'>
    </td>
</table>
</form>
<script type="text/javascript">
	new Validation('form');
</script>