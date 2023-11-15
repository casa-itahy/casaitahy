<?php 
		include_once("php/sessao.php");
                session_write_close();
		include_once("includes/db.php");		
                include_once("includes/functions.php");

$id = $_GET['id'];

$sql = "SELECT * FROM ".$paginas['pag_tab_nome']." WHERE id=$id ";
$dados = query($sql);

$cidade_id = $dados[0]['cidade'];
    /*$sql = "SELECT c.dsc_cidade,c.id_cidade,e.id_estado
            FROM cidades c
            LEFT JOIN estados e ON(c.cod_estado = e.id_estado)
            WHERE c.id_cidade=$cidade_id";
    $return = query($sql);*/
$estado_id = $dados[0]['estado'];

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
        
$atributos_itens = getAtributosItens(18); //clientes

$sql = "SELECT d.titulo,d.src,cd.pasta,d.id FROM docs as d
        LEFT JOIN clientes_docs as cd ON(d.id=cd.docs_id)
        WHERE cd.clientes_id=$id";
$arquivos = query($sql);

//var_dump($sql);
//die();

?>

<script type="text/javascript" src="js/modulos_js/associados.js"></script>
<!-- <script type="text/javascript" src="js/validation.js"></script> -->
<link rel="stylesheet" type="text/css" href="css/style.css" />

<style type="text/css">
    #gallery { width:100%; list-style-type:none; margin:0px; padding:0px; }
    #gallery li { display: inline-block; width:180px; max-height:180px; margin:3px; }
    #gallery div { max-width:180px; max-height:180px;  border:none; text-align:center; }
    .placeHolder div { background-color:white !important; border:dashed 1px gray !important; }
</style>

<form action="_update/<?php echo $paginas['pag_tab_nome'].'.php'; ?>" enctype="multipart/form-data" method="post" id="form" name="form" >
<input type="hidden" id="tabela" name="tabela" value="<?php echo $paginas['pag_tab_nome']; ?>" >
<input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" >
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" >
<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><h1>Editar
    <?php
        echo $paginas['titulo'];
            session_write_close();
    ?></h1></td>
  </tr>
  
  <tr>
    <td height="15" colspan="4" align="center"></td>
  </tr>
  <?php //########### VERIFICA O STATUS DO ATRIBUTO ###################        
       
        $ok = getStatusAtributo($atributos_itens,'nome');
        if($ok!=false){?>
      <tr>
        <td width="154" class="titulo_noticias"><?php echo $ok; ?></td>
        <td width="163" colspan="2" class="titulo_noticias"><label>
          <input name="nome" type="text" id="nome" size="55"  class="required" value="<?php echo $dados[0]['nome']; ?>">
        </label></td>
        <td width="443" align="center" class="titulo_noticias">&nbsp;</td>
      </tr>
  <?php } 
        //########### VERIFICA O STATUS DO ATRIBUTO ###################        
       
  $ok = getStatusAtributo($atributos_itens,'site');
        if($ok!=false){?>
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
    <td colspan="2" class="titulo_noticias"><input name="site" type="text" id="site" size="55"  value="<?php echo $dados[0]['site']; ?>" /></td>
    <td rowspan="4" align="center" valign="top" class="titulo_noticias">&nbsp;</td>
    </tr><?php } 
        //########### VERIFICA O STATUS DO ATRIBUTO ###################   
  $ok = getStatusAtributo($atributos_itens,'fone');
        if($ok!=false){?>
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
    <td colspan="2" class="titulo_noticias"><input name="telefone" type="text" id="telefone" size="55"  value="<?php echo $dados[0]['fone']; ?>" /></td>
  </tr><?php } 
        //########### VERIFICA O STATUS DO ATRIBUTO ###################  
  $ok = getStatusAtributo($atributos_itens,'celular');
        if($ok!=false){?>
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
    <td colspan="2" class="titulo_noticias"><input name="celular" type="text" id="celular" size="55"  value="<?php echo $dados[0]['celular']; ?>" /></td>
  </tr><?php } 
        //########### VERIFICA O STATUS DO ATRIBUTO ###################   
  $ok = getStatusAtributo($atributos_itens,'fax');
        if($ok!=false){?>
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
    <td colspan="2" class="titulo_noticias"><input name="fax" type="text" id="fax" size="55"  value="<?php echo $dados[0]['fax']; ?>" /></td>
  </tr><?php } 
        //########### VERIFICA O STATUS DO ATRIBUTO ###################  
  $ok = getStatusAtributo($atributos_itens,'email');
        if($ok!=false){?>
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
    <td colspan="2" class="titulo_noticias"><input name="email" type="text" id="email" size="55"  class="validate-email" value="<?php echo $dados[0]['email']; ?>" /></td>
    </tr><?php } 
        //########### VERIFICA O STATUS DO ATRIBUTO ################### 
  $ok = getStatusAtributo($atributos_itens,'endereco');
        if($ok!=false){?>
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
    <td colspan="2" class="titulo_noticias"><input name="endereco" type="text" id="endereco" size="55" value="<?php echo $dados[0]['endereco']; ?>" /></td>
    </tr>  <?php } 
        //########### VERIFICA O STATUS DO ATRIBUTO ################### 
 $ok = getStatusAtributo($atributos_itens,'estado');
        if($ok!=false){?>
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>    
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
  </tr><?php } 
        //########### VERIFICA O STATUS DO ATRIBUTO ################### 
  $ok = getStatusAtributo($atributos_itens,'cidade');
        if($ok!=false){?>
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
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
  </tr><?php } 
        //########### VERIFICA O STATUS DO ATRIBUTO ################### 
  $ok = getStatusAtributo($atributos_itens,'cidade');
        if($ok!=false){?>
  <tr>
    <td class="titulo_noticias">Outra cidade</td>
    <td colspan="2" class="titulo_noticias"><input name="cidade_txt" type="text" id="cidade_txt" size="55"  value="<?php echo $dados[0]['cidade_txt']; ?>" /></td>
  </tr><?php } 
        //########### VERIFICA O STATUS DO ATRIBUTO ###################  
  $ok = getStatusAtributo($atributos_itens,'regiao');
        if($ok!=false){?>
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
    <td colspan="2" class="titulo_noticias"><input name="regiao" type="text" id="regiao" size="55"  value="<?php echo $dados[0]['regiao']; ?>" /></td>
  </tr><?php } 
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
  $ok = getStatusAtributo($atributos_itens,'login');
        if($ok!=false){?> 
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
    <td colspan="2" class="titulo_noticias"><input name="login" type="text" id="login" value="<?php echo $dados[0]['login']; ?>" maxlength="25" size="25"/></td>
  </tr><?php } 
        //########### VERIFICA O STATUS DO ATRIBUTO ###################  
        $ok = getStatusAtributo($atributos_itens,'senha');
        if($ok!=false){?>
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
    <td colspan="2" class="titulo_noticias">
        <input type="password" name="pass" id="pass" maxlength="12" size="25" />
    </td>
  </tr>
  <tr style="display: none;">
    <td class="titulo_noticias">Senha Expira?</td>
    <td class="titulo_noticias"><label for="pass"></label>
        <input type="radio" id="senhaNaoExpira" name="expiraSenha" value="0" <?php if($dados[0]['expira'] == 0){ ?>checked="checked"<?php } ?> /> Não
        <input type="radio" id="senhaExpira" name="expiraSenha" value="1" <?php if($dados[0]['expira'] == 1){ ?>checked="checked"<?php } ?> /> Sim
        </td>
    <td class="valor_prod">&nbsp;</td>
  </tr>
  <?php if($dados[0]['expira'] == 0){ ?>
  <div id="senhaExp" style="display:none">
      <tr id="LiberadOo" style="display:none">
        <td class="titulo_noticias">Em que data?</td>
        <td class="titulo_noticias"><label for="pass"></label>
            <input type="text" name="diasSen" id="dataEx"/></td>
        <td class="valor_prod">&nbsp;</td>
      </tr>
  </div>
  <?php } ?>
  <?php if($dados[0]['expira'] == 1){ ?>
  <div id="senhaExp">
      <tr id="agoraVai">
        <td class="titulo_noticias">Em que data?</td>
        <td class="titulo_noticias"><label for="pass"></label>
            <input type="text" name="diasSen" id="dataEx" value="<?php echo $dados[0]['expiraSenha']; ?>"/></td>
        <td class="valor_prod">&nbsp;</td>
      </tr>
  </div>
  <?php } ?>
  <?php } 
   //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'imagens');
        if($ok!=false){
  ?>
  <tr>
    <td colspan="4" class="titulo_noticias">
        <br /> <br />
        <div style="width: 100%; text-align: center;"><?php echo $ok; ?></div>
    </td>
  </tr>
  <tr>
      <td colspan="4" class="titulo_noticias" >          
    <!--   CRIAÇÃO DE ALBUNS FLUTUANTE DRAG DROP -->    
        <?php	                
               $html='';
               if(empty($arquivos[0]['src'])){
                    $msg = "Nenhum arquivo!";
                    $html .= "<span class='msg'>".$msg."</span>";
               }else{
                   $html.= "<table style='width:100%; border:1px solid; #00267F'> 
                                    <th style='text-align:center; border-bottom: 1px solid #00267F; border-right: 1px solid #00267F;'>Nome</th>
                                    <th style='text-align:center; border-bottom: 1px solid #00267F;'>Excluir</th>";
                   foreach($arquivos as $i => $img){
                        $html.= "<tr>
                                    <td style='text-align:center; font-weight:normal; border-bottom: 1px solid #AEAEAE; border-right: 1px solid #AEAEAE;'>".$img['titulo']."</td>
                                    <td align='center' style='border-bottom: 1px solid #AEAEAE;'>
                                            <a href=javascript:confirmar('php/xfile.php?id=".$img['id']."&cliente=".$id."') >
                                                <img src='./img/excluir.gif' alt='Excluir' title='Excluir' width='10' height='10' border='0'>
                                        </a>
                                    </td>";
                   }
                   $html.= "</table>";
               }
               echo $html;	
               ?>
		<script type="text/javascript">
                       function confirmar(query){
                        if(window.confirm("Deseja realmente excluir essa imagem?")){
                                   window.location= query;
                                   return true;
                                }
                        }             
	    </script>        
<!-- FIM MONTA DRAG DROP -->
</td>
 </tr>
<?php 
   }
?>
  <tr>
    <td colspan="4"  class="titulo_noticias">
        <br /><br />
        <input type="submit" value="Atualizar dados" class="botao_form" style="height: 25px; font-size: 14px;">
    </td>
  </tr>
  
</table>
</form>

   
  <?php         
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'imagens');
        if($ok!=false){
  ?>    
            <iframe src="./_add/add_multifile_docs.php?id=<?php echo $id; ?>" width="100%" height="400" frameborder="0" allowtransparency="true" style="border: none; margin:0px; padding:0px;">
              <p>Seu navegador não suporta IFrames. <br/>Você poderá atualiza-lo ou instalar uma versão mais recente no site do proprietário. <br/>http://www.firefox.com <br/> http://www.google.com/chrome</p>
            </iframe>
  <?php } 
        
        
function monta_textarea($idiomas,$nome){
    $text_html='';
    foreach($idiomas as $item){
        $text_html.= '<td class="titulo_noticias" style="font-weight: normal;">'.$item['nome'].'</td>
            <td class="titulo_noticias">
                <textarea name="'.$nome.$item['sigla'].'" id="'.$nome.$item['sigla'].'" cols="38" rows="3"></textarea>
            </td>';
    }
    return $text_html;
}
function monta_input($idiomas,$nome){
    foreach($idiomas as $item){
        echo '<td class="titulo_noticias" style="font-weight: normal;">'.$item['nome'].'</td>
        <td class="titulo_noticias"><label>
            <input name="'.$nome.$item['sigla'].'" type="text" id="'.$nome.$item['sigla'].'" size="55" />
        </label></td>';
    }
}
/*

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
 */

?>