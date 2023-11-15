<?php 
include("php/sessao.php");
session_write_close();

$dados = query("SELECT * FROM valores ORDER BY id ASC");

?>

<script type="text/javascript" src="js/modulos_js/formataReais.js"></script>

<script type="text/javascript" src="js/modulos_js/associados.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<link href="../css/default.css" rel="stylesheet" type="text/css" />
<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="15" align="center"><p class="msg"><?php echo $_GET['msg']; ?></p></td>
  </tr>
  <tr>
    <td align="left" class="titulo_noticias"><h1>
    <?php echo $paginas['titulo']; ?>
    </h1></td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">
    <form method="post" action="_update/valores.php" id="form" name="form" >
    <table width="100%" border="0" cellpadding="3" cellspacing="3">
      <tr>
        <td width="15%" class="titulo_noticias">1 Pessoa</td>
        <td width="80%">
          <input onkeypress="reais(this,event)" onkeydown="backspace(this,event)" name="valor_1" type="text" size="30" class="required" value="<?php echo str_replace('.', ',', $dados[0]['valor']); ?>"/>
        </td>
      </tr>
      <tr>
        <td class="titulo_noticias">2 Pessoas</td>
        <td>
          <input onkeypress="reais(this,event)" onkeydown="backspace(this,event)" name="valor_2" type="text" size="30" class="required" value="<?php echo str_replace('.', ',', $dados[1]['valor']); ?>"/>
        </td>
      </tr>
      <tr>
        <td class="titulo_noticias">3 Pessoas</td>
        <td>
          <input onkeypress="reais(this,event)" onkeydown="backspace(this,event)" name="valor_3" type="text" size="30" class="required" value="<?php echo str_replace('.', ',', $dados[2]['valor']); ?>"/>
        </td>
      </tr>
      <tr>
        <td class="titulo_noticias">4 Pessoas</td>
        <td>
          <input onkeypress="reais(this,event)" onkeydown="backspace(this,event)" name="valor_4" type="text" size="30" class="required" value="<?php echo str_replace('.', ',', $dados[3]['valor']); ?>"/>
        </td>
      </tr>
      <tr>
        <td class="titulo_noticias">5 Pessoas</td>
        <td>
          <input onkeypress="reais(this,event)" onkeydown="backspace(this,event)" name="valor_5" type="text" size="30" class="required" value="<?php echo str_replace('.', ',', $dados[4]['valor']); ?>"/>
        </td>
      </tr>
      <tr>
        <td class="titulo_noticias">6 Pessoas</td>
        <td>
          <input onkeypress="reais(this,event)" onkeydown="backspace(this,event)" name="valor_6" type="text" size="30" class="required" value="<?php echo str_replace('.', ',', $dados[5]['valor']); ?>"/>
        </td>
      </tr>
      <tr>
        <td class="titulo_noticias">7 Pessoas</td>
        <td>
          <input onkeypress="reais(this,event)" onkeydown="backspace(this,event)" name="valor_7" type="text" size="30" class="required" value="<?php echo str_replace('.', ',', $dados[6]['valor']); ?>"/>
        </td>
      </tr>
      <tr>
        <td class="titulo_noticias">8 Pessoas</td>
        <td>
          <input onkeypress="reais(this,event)" onkeydown="backspace(this,event)" name="valor_8" type="text" size="30" class="required" value="<?php echo str_replace('.', ',', $dados[7]['valor']); ?>"/>
        </td>
      </tr>
      <tr>
        <td class="titulo_noticias">9 Pessoas</td>
        <td>
          <input onkeypress="reais(this,event)" onkeydown="backspace(this,event)" name="valor_9" type="text" size="30" class="required" value="<?php echo str_replace('.', ',', $dados[8]['valor']); ?>"/>
        </td>
      </tr>
      <tr>
        <td class="titulo_noticias">10 Pessoas</td>
        <td>
          <input onkeypress="reais(this,event)" onkeydown="backspace(this,event)" name="valor_10" type="text" size="30" class="required" value="<?php echo str_replace('.', ',', $dados[9]['valor']); ?>"/>
        </td>
      </tr>
      <tr>
        <td class="titulo_noticias">11 Pessoas</td>
        <td>
          <input onkeypress="reais(this,event)" onkeydown="backspace(this,event)" name="valor_11" type="text" size="30" class="required" value="<?php echo str_replace('.', ',', $dados[10]['valor']); ?>"/>
        </td>
      </tr>
      <tr>
        <td class="titulo_noticias">&nbsp;</td>
        <td align="right"><input type="submit" name="gravar" id="gravar" class="botao_form" value="Gravar" /></td>
        <td><label></label></td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
</table>
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
				notEqualToField : 'usuario'
			}],
			['validate-password-confirm', 'Sua confirma��o de senha n�o � igual a sua primeira senha, por favor repita.', {
				equalToField : 'senha'
			}]
		]);
</script>
	