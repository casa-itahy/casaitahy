<?php 
include("php/sessao.php");
session_write_close();

$sql = "SELECT * FROM config WHERE id=1 ";
$dados = query($sql);

$cidade_id = $dados[0]['cidade'];

if(!is_null($cidade_id)){
    $sql = "SELECT c.dsc_cidade,c.id_cidade,e.id_estado
            FROM cidades c
            LEFT JOIN estados e ON(c.cod_estado = e.id_estado)
            WHERE c.id_cidade=$cidade_id";
    $return = query($sql);
    $estado_id = $return[0]['id_estado'];
}else{
    $estado_id = $dados[0]['estado'];
}

if(!is_null($estado_id)){
    $sql = "SELECT c.dsc_cidade,c.id_cidade
            FROM cidades c WHERE c.cod_estado='".$estado_id."' ORDER BY c.dsc_cidade ";
    $cidadesItens = query($sql);
}else{
    $cidadesItens =array();
}

$sql = "SELECT a.id_estado, a.dsc_estado, a.sigl_estado
        FROM estados a ORDER BY a.dsc_estado";
$estadosItens = query($sql);

?>
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
    <form method="post" action="_update/config.php" id="form" name="form" >
    <table width="100%" border="0" cellpadding="3" cellspacing="3">
      <tr>
        <td width="13%" class="titulo_noticias">T&iacute;tulo</td>
        <td width="33%">
          <input name="titulo" type="text" id="titulo" size="30" class="required" value="<?php echo $dados[0]['titulo']; ?>"/>        </td>
        <td width="54%"><span class="valor_prod"> - Esta informa&ccedil;&atilde;o aparecer&aacute; na barra de t&iacute;tulos do navegador</span></td>
      </tr>
      <tr style="display: none;">
        <td class="titulo_noticias">Resultados de Exames</td>
        <td><input name="portal" type="text" size="50" value="<?php echo $dados[0]['portal']; ?>"/></td>
        <td><span class="valor_prod"></span></td>
      </tr>
      <tr>
        <td class="titulo_noticias">Endereço</td>
        <td><textarea name="enderecoC" id="enderecoC" rows="4" cols="40"><?php echo $dados[0]['endereco']; ?></textarea></td>
        <td><span class="valor_prod"></span></td>
      </tr>      
      <tr>
        <td class="titulo_noticias">CEP</td>
        <td><input name="cep" type="text" size="50" value="<?php echo $dados[0]['cep']; ?>"/></td>
        <td><span class="valor_prod"></span></td>
      </tr>
       <tr>
    <td class="titulo_noticias">Estado</td>
    <td class="titulo_noticias">
        <select name="estado" id="estado" onChange="atualizaCidade()">
            <option value="null">Selecione o estado </option>
            <?php foreach($estadosItens as $item) {
                    if($item['id_estado']==$estado_id)$selected='selected';else$selected='';
                        echo "<option value='".$item['id_estado']."' $selected >".$item['dsc_estado']."</option>";
                        $selected='';
            } ?>
        </select>
    </td>
    <td class="titulo_noticias">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">Cidade</td>
    <td colspan="2" class="titulo_noticias">
            <div id="div_cidade">
            <?php
                 echo '<select name="cidade" id="cidade" >
                        <option value="null">Selecione a cidade</option>';
                            foreach ($cidadesItens as $itens){
                                if($itens['id_cidade']==$cidade_id)$selected='selected';else $selected='';
                                echo "<option value='".$itens['id_cidade']."' $selected >".$itens['dsc_cidade']."</option>";
                                $selected='';
                            }
                 echo'</select>';
            ?>
            </div>
    </td>
    <td class="titulo_noticias">&nbsp;</td>
    </tr>
      <tr>
        <td class="titulo_noticias">Telefone</td>
        <td><input name="telefoneC" type="text" id="telefoneC" size="50"  value="<?php echo $dados[0]['fone1']; ?>"/></td>
        <td><span class="valor_prod"></span></td>
      </tr>
      <tr>
        <td class="titulo_noticias">Whatsapp</td>
        <td><input name="celularC" type="text" id="celularC" size="50" value="<?php echo $dados[0]['fone2']; ?>"/></td>
        <td><span class="valor_prod"></span></td>
      </tr>
      <tr style="display: none;">
        <td class="titulo_noticias">SAC</td>
        <td><input name="fone3" type="text" id="fone3" size="50" value="<?php echo $dados[0]['fone3']; ?>"/></td>
        <td><span class="valor_prod"></span></td>
      </tr>
      <tr>
        <td class="titulo_noticias">Email Contato</td>
        <td><input name="emailC" type="text" id="emailC" size="50" class="validate-email" value="<?php echo $dados[0]['emailC']; ?>"/></td>
        <td></td>
      </tr>
      <tr style="display: none;">
        <td class="titulo_noticias">Horário de Atendimento</td>
        <td><textarea name="horario" id="horario" rows="4" cols="40"><?php echo $dados[0]['horario']; ?></textarea></td>
        <td><span class="valor_prod"></span></td>
      </tr>
      <tr>
        <td class="titulo_noticias">Site</td>
        <td><input name="www" type="text" id="www" size="50" class="validate-url" value="<?php echo $dados[0]['www']; ?>" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="titulo_noticias">Descri&ccedil;&atilde;o</td>
        <td><input name="descricao" type="text" id="descricao" size="50" class="required" value="<?php echo $dados[0]['descricao']; ?>"/></td>
        <td class="valor_prod">- Descri&ccedil;&atilde;o que aparecer&aacute; nos sites de busca</td>
      </tr>
      <tr>
        <td class="titulo_noticias">Scripts</td>
        <td><label>
          <textarea name="scripts" id="scripts" cols="38" rows="3"><?php echo $dados[0]['scripts']; ?></textarea>
        </label></td>
        <td class="valor_prod">Códigos para Inserir na Header (Analytics, Facebook Ads)</td>
      </tr>
      <tr>
        <td class="titulo_noticias">Scripts</td>
        <td><label>
          <textarea name="scripts_body" id="scripts_body" cols="38" rows="3"><?php echo $dados[0]['scripts_body']; ?></textarea>
        </label></td>
        <td class="valor_prod">Códigos para Inserir no inicio do Body (Analytics, Facebook Ads)</td>
      </tr>
      <tr style="display: none;">
        <td class="titulo_noticias">Palavras Chave</td>
        <td><input name="palavra" type="text" id="palavra" size="50" class="required" value="<?php echo $dados[0]['palavra']; ?>"/></td>
        <td class="valor_prod"> - Separe as palavras com v&iacute;rgulas</td>
      </tr>
      <tr>
        <td class="titulo_noticias">Rodap&eacute;</td>
        <td><label>
          <textarea name="rodape" id="rodape" cols="38" rows="3" class="required"><?php echo $dados[0]['rodape']; ?></textarea>
        </label></td>
        <td class="valor_prod">&nbsp;</td>
      </tr>
      <tr>
         <td class="titulo_noticias" colspan="3"><br />Redes Sociais:</td>        
      </tr>
      <tr>
        <td class="titulo_noticias">Facebook</td>
        <td><input name="rede1" type="text" id="rede1" size="50" value="<?php echo $dados[0]['rede1']; ?>" /></td>
        <td class="valor_prod">&nbsp;</td>
      </tr>
      <tr>
        <td class="titulo_noticias">Linkedin</td>
        <td><input name="rede2" type="text" id="rede2" size="50" value="<?php echo $dados[0]['rede2']; ?>" /></td>
        <td class="valor_prod">&nbsp;</td>
      </tr>
      <tr>
        <td class="titulo_noticias">Instagram</td>
        <td><input name="rede3" type="text" id="rede3" size="50" value="<?php echo $dados[0]['rede3']; ?>" /></td>
        <td class="valor_prod">&nbsp;</td>
      </tr>
      <tr>
        <td class="titulo_noticias">Twitter</td>
        <td><input name="rede4" type="text" id="rede4" size="50" value="<?php echo $dados[0]['rede4']; ?>" /></td>
        <td class="valor_prod">&nbsp;</td>
      </tr>
      <tr>
        <td class="titulo_noticias">YouTube</td>
        <td><input name="rede5" type="text" id="rede5" size="50" value="<?php echo $dados[0]['rede5']; ?>" /></td>
        <td class="valor_prod">&nbsp;</td>
      </tr>
      <tr>
        <td class="titulo_noticias">Pinterest</td>
        <td><input name="rede6" type="text" id="rede6" size="50" value="<?php echo $dados[0]['rede6']; ?>" /></td>
        <td class="valor_prod">&nbsp;</td>
      </tr>
      <tr>
         <td class="titulo_noticias" colspan="3"><br />Dados para envio de emails seguros:</td>        
      </tr>
      <tr>
        <td class="titulo_noticias">SMTP site</td>
        <td><input name="smtp_host" type="text" id="smtp_host" size="50" class="required" value="<?php echo $dados[0]['smtp_host']; ?>"/></td>
        <td class="valor_prod"> - Ex: smtp.seusite.com.br ou seusite.com.br</td>
      </tr>
      <tr>
        <td class="titulo_noticias">SMTP email</td>
        <td><input name="smtp_email" type="text" id="smtp_email" size="50" class="required" value="<?php echo $dados[0]['smtp_email']; ?>"/></td>
        <td class="valor_prod"> - Ex: servidor@seusite.com.br</td>
      </tr>
      <tr>
        <td class="titulo_noticias">SMTP senha</td>
        <td><input name="smtp_pass" type="password" id="smtp_pass" size="50" class="required" value="<?php echo $dados[0]['smtp_pass']; ?>"/></td>
        <td class="valor_prod"> - Senha para enviar emails</td>
      </tr>
      <tr>
        <td class="titulo_noticias">Responder ao cliente</td>
        <td><input name="envio_resp" type="text" id="envio_resp" size="50" class="required" value="<?php echo $dados[0]['envio_resposta']; ?>"/></td>
        <td class="valor_prod">Deixe este campo em branco para NÃO enviar uma resposta ao cliente.</td>
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
	