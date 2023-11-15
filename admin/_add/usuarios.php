<?php 
    include_once("php/sessao.php");
    include_once("includes/db.php");

    $id_usu=$_SESSION['id'];    
    session_write_close();
        
    if($id_usu!='null' && $id_usu!=''){
        if($id_usu==1){
            $sql = "SELECT m.id, m.descricao,m.pag_tab_nome FROM modulos m where m.status=1 AND m.descricao IS NOT NULL order by titulo";
        }else{
            $sql = "SELECT m.id, m.descricao,m.pag_tab_nome FROM modulos m
                        INNER JOIN usuarios_modulos um ON(m.id = modulo_id) WHERE um.usuario_id=".$id_usu." AND m.status=1 AND m.descricao IS NOT NULL order by m.titulo"; //AND pag_tab_nome!='usuarios' AND pag_tab_nome!='config'";
        }
        $modulos = query($sql);
    }else{            
        header('Location: ../php/sair');
        exit;
    }    
    
?>

	<script type="text/javascript" src="js/validation.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css" />

<script language="javascript">
function lowcase(form){
    var texto = document.getElementById('login').value;
	texto = texto.replace(' ','');
	document.getElementById('login').value = texto;
        }
</script>

<form action="_gravar/usuarios.php" enctype="multipart/form-data" method="post" id="form" name="form" >

<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><h1>Incluir 
    <?php
        echo $paginas['titulo'];
        session_write_close();
    ?>
    </h1></td>
  </tr>
  
  <tr>
    <td height="15" colspan="3" align="center"></td>
  </tr>
  <tr>
    <td width="154" class="titulo_noticias">Nome completo</td>
    <td colspan="2" class="titulo_noticias"><label>
      <input name="nome" type="text" id="nome" size="55"  class="required">
    </label></td>
  </tr>

  <tr>
    <td class="titulo_noticias">Login</td>
    <td class="titulo_noticias"><input name="login" type="text" id="login" size="20"  class="required" onchange="lowcase(this)" /></td>
    <td class="valor_prod">- O sistema ir&aacute; remover espa&ccedil;os em brancos automaticamente.</td>
  </tr>
  <tr>
    <td class="titulo_noticias">Senha</td>
    <td colspan="2" class="titulo_noticias"><input name="senha" type="password" id="senha" size="20"  class="required validate-password" title="Digite uma senha maior que 6 caracteres" /></td>
  </tr>
  <tr>
    <td class="titulo_noticias">Confirma&ccedil;&atilde;o de Senha</td>
    <td colspan="2" class="titulo_noticias"><input type="password" name="senhaC" id="senhaC" class="required validate-password-confirm"  /></td>
  </tr>
  <tr>
    <td rowspan="2" class="titulo_noticias">N&iacute;vel de Acesso</td>
    <td width="163" rowspan="2" class="titulo_noticias"><label>
      <select name="nivel" id="nivel"  class="validate-selection">
        <option selected="selected">-- Escolha --</option>
        <option value="1">Administrador</option>
        <option value="0">Gerente</option>
            </select>
    </label></td>
    <td width="443" class="valor_prod">- Administrador - Acesso total as paginas permitidas.</td>
  </tr>
  <tr>
    <td class="valor_prod">- Gerente - Proibido acesso aos usuarios, adicionar e remover conte&uacute;dos.</td>
  </tr>
  <tr>
    <td colspan="3" class="titulo_noticias">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">&nbsp;</td>
    <td colspan="2" class="valor_prod">O usu&aacute;rio acima ter&aacute; acesso as p&aacute;ginas marcadas abaixo:</td>
  </tr>
  <?php  foreach ($modulos as $p){    ?>
             <tr>
            <td class="titulo_noticias">&nbsp;</td>
            <td colspan="2" class="titulo_noticias">
                <input name="<?php echo $p['id']; ?>" type="checkbox" id="<?php echo $p['id']; ?>" value="1" />
                <?php echo $p['descricao']; ?>
            </td>
            </tr>
<?php	} ?> 
  <tr>
    <td colspan="3" align="right" class="titulo_noticias"><input type="submit" value="Salvar" class="botao_form" /></td>
  </tr>
</table>
</form>
<script type="text/javascript">
	new Validation('form');
</script>
<script type="text/javascript">
						function formCallback(result, form) {
							window.status = "valiation callback for form '" + form.id + "': result = " + result;
						}
						
						var valid = new Validation('form', {immediate : true, onFormValidate : formCallback});
						Validation.addAllThese([
							['validate-password', 'Sua senha deve ser maior que 6 caracteres e n�o pode ser igual ao seu usuario', {
								minLength : 6,
								notOneOf : ['password','PASSWORD','1234567','0123456'],
								notEqualToField : 'login'
							}],
							['validate-password-confirm', 'Sua confirma��o de senha n�o � igual a sua primeira senha, por favor repita.', {
								equalToField : 'senha'
							}]
						]);
</script>	