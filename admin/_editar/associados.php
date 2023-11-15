<?php 
		include_once("php/sessao.php");
                session_write_close();
		include_once("includes/db.php");		

$id = $_GET['id'];

$sql = "SELECT * FROM associados WHERE id=$id ";
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
  <tr>
    <td width="154" class="titulo_noticias">Nome</td>
    <td width="163" colspan="2" class="titulo_noticias"><label>
      <input name="nome" type="text" id="nome" size="55"  class="required" value="<?php echo $dados[0]['nome']; ?>">
    </label></td>
    <td width="443" align="center" class="titulo_noticias">&nbsp;</td>
  </tr>

  <tr style="display: none;">
    <td class="titulo_noticias">Site</td>
    <td colspan="2" class="titulo_noticias"><input name="site" type="text" id="site" size="55"  value="<?php echo $dados[0]['site']; ?>" /></td>
    <td rowspan="4" align="center" valign="top" class="titulo_noticias">&nbsp;</td>
    </tr>
  <tr>
    <td class="titulo_noticias">Telefone</td>
    <td colspan="2" class="titulo_noticias"><input name="telefone" type="text" id="telefone" size="55"  value="<?php echo $dados[0]['fone']; ?>" /></td>
  </tr>
  <tr style="display: none;">
    <td class="titulo_noticias">Celular</td>
    <td colspan="2" class="titulo_noticias"><input name="celular" type="text" id="celular" size="55"  value="<?php echo $dados[0]['celular']; ?>" /></td>
  </tr>
  <tr style="display: none;">
    <td class="titulo_noticias">Fax/Nextel</td>
    <td colspan="2" class="titulo_noticias"><input name="fax" type="text" id="fax" size="55"  value="<?php echo $dados[0]['fax']; ?>" /></td>
  </tr>
  <tr style="display: none;">
    <td class="titulo_noticias">E-mail</td>
    <td colspan="2" class="titulo_noticias"><input name="email" type="text" id="email" size="55"  class="validate-email" value="<?php echo $dados[0]['email']; ?>" /></td>
    </tr>
  <tr>
    <td class="titulo_noticias">Endereço</td>
    <td colspan="2" class="titulo_noticias"><textarea name="endereco" rows="4" cols="40"><?php echo $dados[0]['endereco']; ?></textarea></td>
  </tr>  
  <tr style="display: none;">
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
  <tr style="display: none;">
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
    <td class="titulo_noticias">Link</td>
    <td colspan="2" class="titulo_noticias"><input name="regiao" type="text" id="regiao" size="55"  value="<?php echo $dados[0]['regiao']; ?>" /></td>
  </tr>  
  
    <tr>
        <td class="titulo_noticias">Logomarca</td>
        <td class="titulo_noticias">
            <?php
                $caminho = "imagens/associados/thumb_".$dados[0]['logomarca'];
                if (!empty($dados[0]['logomarca'])) {
            ?>
                <img src="<?php echo $caminho; ?>"/>
                &nbsp;
                <a href="php/apagarImgAssociado.php?g=1&id=<?php echo $id; ?>&pag=<?php echo $paginas['pag_tab_id']; ?>">
                    Apagar
                </a>
            <?php
                } else {
            ?>
                <input name="imagem" type="file" id="imagem" size="46">			
            <?php } ?>
        </td>    
    </tr>

 
  <!--<tr>
    <td colspan="3" class="titulo_noticias">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">Login</td>
    <td colspan="2" class="titulo_noticias"><input name="login" type="text" id="login" value="<?php echo $dados[0]['login']; ?>" maxlength="25" size="25"/></td>
  </tr>
  <tr>
    <td class="titulo_noticias">Senha</td>
    <td colspan="2" class="titulo_noticias">
        <input type="password" name="pass" id="pass" maxlength="12" size="25" />
    </td>    
  </tr>-->
  <tr>
    <td colspan="3" class="titulo_noticias">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="right" class="titulo_noticias">
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