<?php 
    include_once("php/sessao.php");
    session_write_close();
    $sql = "SELECT a.id_estado, a.dsc_estado, a.sigl_estado
            FROM estados a
                    ORDER BY a.dsc_estado";
    $estadosItens = query($sql);
    include_once("includes/functions.php");

    $atributos_itens = getAtributosItens(18); //11 páginas
?>
<script language="JavaScript" type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/modulos_js/associados.js"></script>
<script type="text/javascript" src="js/modulos_js/mascaras.js"></script>
<script type="text/javascript" src="js/livevalidation.js"></script>
<script type="text/javascript" src="js/niceforms.js"></script>
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
  <?php //########### VERIFICA O STATUS DO ATRIBUTO ###################        
        $ok = getStatusAtributo($atributos_itens,'nome');        
        if($ok!=false){
  ?>
  <tr>
    <td width="154" class="titulo_noticias"><?php echo $ok; ?></td>
    <td width="163" class="titulo_noticias"><label>
      <input name="nome" type="text" id="nome" size="55"  class="required">
    </label></td>
    <td width="443" align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
  <?php }//########### VERIFICA O STATUS DO ATRIBUTO ###################        
        $ok = getStatusAtributo($atributos_itens,'site');         
        if($ok!=false){
  ?>
      <tr>
        <td class="titulo_noticias"><?php echo $ok; ?></td>
        <td class="titulo_noticias"><label for="site"></label>
          <input name="site" type="text" id="site" size="55" /></td>
        <td align="center" class="valor_prod">&nbsp;</td>
      </tr>
  <?php }//########### VERIFICA O STATUS DO ATRIBUTO ###################                
        $ok = getStatusAtributo($atributos_itens,'telefone');         
        if($ok!=false){
  ?>    
      <tr>
        <td class="titulo_noticias"><?php echo $ok; ?></td>
        <td class="titulo_noticias"><label for="telefone"></label>        
            <input type="text" name="telefone" id="telefone" onkeypress="mascara(this,telefone)" /></td>
        <td class="valor_prod">&nbsp;</td>
      </tr>
  <?php }//########### VERIFICA O STATUS DO ATRIBUTO ###################                
        $ok = getStatusAtributo($atributos_itens,'celular');         
        if($ok!=false){
  ?>    
      <tr>
        <td class="titulo_noticias"><?php echo $ok; ?></td>
        <td class="titulo_noticias"><label for="celular"></label>
            <input type="text" name="celular" id="celular" /></td>
        <td class="valor_prod">&nbsp;</td>
      </tr>
   <?php }//########### VERIFICA O STATUS DO ATRIBUTO ################### 
            $ok = getStatusAtributo($atributos_itens,'fax');         
        if($ok!=false){
  ?>  
      <tr>
        <td class="titulo_noticias"><?php echo $ok; ?></td>
        <td class="titulo_noticias"><label for="fax"></label>
            <input type="text" name="fax" id="fax" /></td>
        <td class="valor_prod">&nbsp;</td>
      </tr>
   <?php }//########### VERIFICA O STATUS DO ATRIBUTO ###################   
        $ok = getStatusAtributo($atributos_itens,'email');         
        if($ok!=false){
  ?>   
      <tr>
        <td class="titulo_noticias"><?php echo $ok; ?></td>
        <td class="titulo_noticias"><label for="email"></label>
          <input name="email" type="text" id="email" size="55" class="validate-email" /></td>
        <td class="valor_prod">&nbsp;</td>
      </tr>
   <?php }//########### VERIFICA O STATUS DO ATRIBUTO ###################  
        $ok = getStatusAtributo($atributos_itens,'endereco');         
        if($ok!=false){    
        
  ?>   
      <tr>
        <td class="titulo_noticias"><?php echo $ok; ?></td>
        <td class="titulo_noticias"><label for="endereco"></label>
          <input name="endereco" type="text" id="endereco" size="55" /></td>
        <td class="valor_prod">&nbsp;</td>
      </tr>
  <?php }//########### VERIFICA O STATUS DO ATRIBUTO ###################        
        $ok = getStatusAtributo($atributos_itens,'estado');  
        if($ok!=false){    
        
  ?>    
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
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
  <?php }//########### VERIFICA O STATUS DO ATRIBUTO ###################  
        $ok = getStatusAtributo($atributos_itens,'cidade');         
        if($ok!=false){    
        
  ?>
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
    <td class="titulo_noticias">
        <div id="div_cidade">Selecione o estado</div>
    </td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <?php }//########### VERIFICA O STATUS DO ATRIBUTO ###################     
        $ok = getStatusAtributo($atributos_itens,'regiao');         
        if($ok!=false){    
        
  ?>
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
    <td class="titulo_noticias"><label for="regiao"></label>
        <input type="regiao" name="regiao" id="fax" maxlength="50"/></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <?php }//########### VERIFICA O STATUS DO ATRIBUTO ###################     
        $ok = getStatusAtributo($atributos_itens,'login');         
        if($ok!=false){    
        
  ?>
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
    <td class="titulo_noticias"><label for="login"></label>
        <input type="text" name="login" id="login" maxlength="12" class="required"/></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <?php }//########### VERIFICA O STATUS DO ATRIBUTO ###################        
     
        $ok = getStatusAtributo($atributos_itens,'senha');         
        if($ok!=false){    
        
  ?>
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
    <td class="titulo_noticias"><label for="pass"></label>
        <input type="password" name="pass" id="pass" maxlength="12"/></td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <?php } ?>
  <tr style="display: none;">
    <td class="titulo_noticias">Senha Expira?</td>
    <td class="titulo_noticias"><label for="pass"></label>
        <input type="radio" id="senhaNaoExpira" name="expiraSenha" value="0" checked="checked" /> Não
        <input type="radio" id="senhaExpira" name="expiraSenha" value="1" /> Sim
        </td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <div id="senhaExp" style="display:none">
  
  
      <tr id="LiberadOo" style="display:none">
        <td class="titulo_noticias">Em que data?</td>
        <td class="titulo_noticias"><label for="pass"></label>
            <input type="text" name="diasSen" id="dataEx"/></td>
        <td class="valor_prod">&nbsp;</td>
      </tr>
  </div>
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
    var nome = new LiveValidation('nome' , {onlyOnSubmit: true } );
    nome.add(Validate.Presence, {failureMessage: "Preencha o Nome!"});
    
    function formCallback(result, form){
       window.status = "valiation callback for form'"+form.id+"':result="+result;
    }

    var valid = new Validation('form', {immediate : true, onFormValidate : formCallback});
    Validation.addAllThese([
            ['validate-password', 'Sua senha deve ser maior que 6 caracteres e não pode ser igual ao seu usuario', {
                    minLength : 6,
                    notOneOf : ['password','PASSWORD','1234567','0123456'],
                    notEqualToField : 'usuario'
            }],
            ['validate-password-confirm', 'Sua confirmação de senha não é igual a sua primeira senha, por favor repita.', {
                    equalToField : 'senha'
            }]
    ]);
</script>	