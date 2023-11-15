<?php 
        include_once("php/sessao.php");
	session_write_close();	
        $sql = "SELECT a.id_estado, a.dsc_estado, a.sigl_estado
                FROM estados a
                        ORDER BY a.dsc_estado";

        $estadosItens = query($sql);


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
            session_write_close();
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

  <tr style="display: none;">
    <td class="titulo_noticias">Site</td>
    <td class="titulo_noticias"><label for="site"></label>
      <input name="site" type="text" id="site" size="55" value="http://" /></td>
    <td align="center" class="valor_prod">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">Telefone</td>
    <td class="titulo_noticias"><label for="telefone"></label>        
        <input type="text" name="telefone" id="telefone" class="email" /></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr style="display: none;">
    <td class="titulo_noticias">Celular</td>
    <td class="titulo_noticias"><label for="celular"></label>
        <input type="text" name="celular" id="celular" /></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr style="display: none;">
    <td class="titulo_noticias">Fax/Nextel</td>
    <td class="titulo_noticias"><label for="fax"></label>
        <input type="text" name="fax" id="fax" /></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr style="display: none;">
    <td class="titulo_noticias">E-mail</td>
    <td class="titulo_noticias"><label for="email"></label>
      <input name="email" type="text" id="email" size="55" class="validate-email" /></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">Endereço</td>
    <td class="titulo_noticias"><label for="endereco"></label>
      <textarea name="endereco" rows="4" cols="40"></textarea></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr style="display: none;">
    <td class="titulo_noticias">Estado</td>
    <td class="titulo_noticias">
        <select name="estado" id="estado" onChange="atualizaCidade()">
    	<option value="null">Selecione o estado </option>
		<?php foreach($estadosItens as $item) {
                           echo "<option value='".$item['id_estado']."'>".$item['dsc_estado']."</option>";
		} ?>
    </select>
    </td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr style="display: none;">
    <td class="titulo_noticias">Cidade</td>
    <td class="titulo_noticias">
        <div id="div_cidade">Selecione o estado</div>
    </td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">Link</td>
    <td class="titulo_noticias"><label for="regiao"></label>
        <input type="regiao" name="regiao" id="fax" size="55" /></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  
    
    <tr>
        <td class="titulo_noticias">Imagem</td>
        <td class="titulo_noticias">
            <input name="imagem" type="file" id="imagem" size="46">			
        </td>    
    </tr>
    
  <tr>
    <td colspan="3" class="titulo_noticias">&nbsp;</td>
  </tr>
  <!--<tr>
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
  </tr>
  <tr>
    <td class="titulo_noticias">Repita Senha</td>
    <td class="titulo_noticias"><label for="senha"></label>
        <input type="senha" name="pass" id="senha" maxlength="12"/></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>-->
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