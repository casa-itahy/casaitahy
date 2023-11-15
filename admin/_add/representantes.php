<?php 
        include_once("php/sessao.php");
		session_write_close();
        $sql = "SELECT a.id_estado, a.dsc_estado, a.sigl_estado
                FROM estados a
                        ORDER BY a.dsc_estado";

        $estadosItens = query($sql);
		
		$categorias = query("SELECT * FROM associados_categoria ORDER BY titulo");

?>

<script type="text/javascript" src="js/modulos_js/associados.js"></script>
<script type="text/javascript" src="js/modulos_js/mascaras.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/default.css"/>


<form action="_gravar/<?php echo $paginas['pag_tab_nome'].'.php'; ?>" enctype="multipart/form-data" method="post" id="form" name="form" >
<input type="hidden" id="tabela" name="tabela" value="<?php echo $paginas['pag_tab_nome']; ?>" >
<input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" >
<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><h1>Incluir <?php
        echo $paginas['titulo'];
            @session_write_close;
    ?></h1></td>
  </tr>
  
  <tr>
    <td height="15" colspan="3" align="center"></td>
  </tr>
  <tr>
    <td width="154" class="titulo_noticias">Nome</td>
    <td width="163" class="titulo_noticias"><label>
      <input name="nome" type="text" id="nome" size="55"  class="required">
    </label></td>
    <td width="443" align="center" class="titulo_noticias">&nbsp;</td>
  </tr>

  <tr style="display:none;">
    <td class="titulo_noticias">Site</td>
    <td class="titulo_noticias"><label for="site"></label>
      <input name="site" type="text" id="site" size="55" /></td>
    <td align="center" class="valor_prod">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">Telefone</td>
    <td class="titulo_noticias"><label for="telefone"></label>        
        <input type="text" name="telefone" id="telefone" maxlength="14" class="email" onkeypress="mascara(this,telefone)" /></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">Celular</td>
    <td class="titulo_noticias"><label for="celular"></label>
        <input type="text" name="celular" id="celular" maxlength="14"/></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr style="display:none;">
    <td class="titulo_noticias">Fax</td>
    <td class="titulo_noticias"><label for="fax"></label>
        <input type="text" name="fax" id="fax" maxlength="12"/></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr style="display:none;">
    <td class="titulo_noticias">E-mail</td>
    <td class="titulo_noticias"><label for="email"></label>
      <input name="email" type="text" id="email" size="55" class="validate-email" /></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">Endere&ccedil;o</td>
    <td class="titulo_noticias"><label for="endereco"></label>
      <input name="endereco" type="text" id="endereco" size="55" /></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">Bairro</td>
    <td class="titulo_noticias"><label for="regiao"></label>
        <input type="regiao" name="regiao" id="fax" maxlength="50"/></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">Latitude</td>
    <td class="titulo_noticias">
        <input type="text" name="latitude" id="latitude" />
    </td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">Longitude</td>
    <td class="titulo_noticias">
        <input type="text" name="longitude" id="longitude" />
    </td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">Estado</td>
    <td class="titulo_noticias">
        <select name="estado" id="estado" class="validate-selection" onChange="atualizaCidade()">
    	<option value="null">Selecione o estado </option>
		<?php foreach($estadosItens as $item) {
                           echo "<option value='".$item['id_estado']."'>".$item['dsc_estado']."</option>";
		} ?>
    </select>
    </td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">Cidade</td>
    <td class="titulo_noticias">
        <div id="div_cidade">Selecione o estado</div>
    </td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <!--
  <tr>
    <td class="titulo_noticias">Login</td>
    <td class="titulo_noticias"><label for="login"></label>
        <input type="text" name="login" id="login" maxlength="12"/></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">Senha</td>
    <td class="titulo_noticias"><label for="pass"></label>
        <input type="password" name="pass" id="pass" maxlength="12"/></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>-->
    <tr>
        <td class="titulo_noticias">Categoria</td>
        <td class="titulo_noticias">
            <select name="categoria" class="validate-selection">
                <option value="null">Selecione</option>
                <?php foreach($categorias as $cs) { ?>
                    <option value="<?php echo $cs['id']; ?>"><?php echo $cs['titulo']; ?></option>
                <?php } ?>
            </select>
        </td>
        <td class="valor_prod">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="3" class="titulo_noticias">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="right" class="titulo_noticias">
      <input type="submit" value="Salvar" class="botao_form">	</td>
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
</script>	