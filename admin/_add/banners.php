<?php 
	$grupos = query('SELECT id, nome FROM grupo_banners WHERE status = 1');

	$idiomas = query("SELECT * FROM idiomas WHERE status=1 AND sigla!='Port'");
?>

<script type="text/javascript" src="js/validation.js"></script>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/banners.js"></script>

<form action="_gravar/banners.php" enctype="multipart/form-data" method="post" id="form" >

<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
<tr>
	<td height="30" colspan="2" align="center">&nbsp;</td>
</tr>
<tr>
	<td colspan="2" align="center">
		<h1>Incluir Banner</h1>
	</td>
</tr>
<tr>
	<td width="150" class="titulo_noticias">T&iacute;tulo</td>
	<td class="titulo_noticias">
		<label>
			<input name="titulo" type="text" id="titulo" size="70"  class="required">
		</label>
    </td>
</tr>
<tr style="display: none;">
	<td class="titulo_noticias">Observações</td>
	<td class="titulo_noticias">
		Colocar o texto entre as tags &lt;strong&gt;Exemplo&lt;/strong&gt; para que o mesmo apareça em outra cor no título do banner.
	</td>
</tr>
<tr>
	<td class="titulo_noticias">Imagem</td>
	<td class="titulo_noticias">
		<input name="imagem" type="file" id="imagem" size="46">			
	</td>    
</tr>
<tr>
	<td class="titulo_noticias">Tamanho</td>
	<td class="titulo_noticias">
		Parceiros: A imagem deve ter 150 pixels de largura e ser retangular.<br />
		Cases: A imagem deve ser quadrada com 480 pixels.<br />
	</td>
</tr>
<?php if (count($grupos) > 1) { ?>
	<tr>
		<td class="titulo_noticias">Grupo</td>
		<td class="titulo_noticias">
			<select id='grupo' name="grupo" class="validate-selection">
				<option value="0"> -- Escolha --</option>
				<?php foreach($grupos as $g) { ?>
					<option value="<?php echo $g['id']; ?>"> <?php echo $g['nome']; ?> </option>
				<?php } ?>
			</select>
		</td>    
	</tr>
<?php } else { ?>
	<tr style="display: none;">
		<td class="titulo_noticias">Grupo</td>
		<td class="titulo_noticias">
			<select id='grupo' name="grupo">
				<?php foreach($grupos as $g) { ?>
					<option value="<?php echo $g['id']; ?>"> <?php echo $g['nome']; ?> </option>
				<?php } ?>
			</select>
		</td>    
	</tr>
<?php } ?>
<tr>
	<td></td>
	<td class="titulo_noticias">Os campos abaixo são usados somente para os Cases.</td>
</tr>
<tr>
	<td class="titulo_noticias">Número</td>
	<td class="titulo_noticias">
		<input size="55" name="texto" type="text" maxlength="2" />
	</td>
</tr>
<tr>
	<td class="titulo_noticias">Texto Inferior</td>
	<td class="titulo_noticias">
		<input name="descricao" type="text" id="descricao" size="55" />
	</td>
</tr>
<tr style="display: none;">
	<td class="titulo_noticias">Link</td>
	<td class="titulo_noticias">
		<input name="urllink" type="text" id="urllink" size="55">
	</td>
</tr>
<tr style="display: none;">
	<td class="titulo_noticias">Observações</td>
	<td class="titulo_noticias">
		Para utilizar formulários via Popup utilize um dos seguinte links: #proposta, #parceiro, #indicacao
	</td>
</tr>

<!--
	<tr>
		<td><input type="radio" name="link" value="cat" />Categorias</td>
		<td>
			<?php
			/*
					$sql = "SELECT id,titulo FROM categorias_subcat WHERE id IN
						(SELECT cat_pai_id FROM cat_subcat_nivel WHERE cat_pai_id IS NOT NULL AND cat_filho_id IS NULL AND cat_neto_id IS NULL)
						AND status=1 ORDER BY titulo";
					$categorias = query($sql);                                
					if (count($categorias) > 0){
							$select = "<select id='categoria' name='categoria' onchange='montaSelect()' class='email' style='min-width: 250px;'>";
							$select .= "<option>Selecione</option>";
							foreach ($categorias as $prod){
									$select .= "<option value='".$prod['id']."'>".$prod['titulo']."</option>";
							}
							$select .= "</select>";
					}else{
							$select = "Nenhum categoria dispon&iacute;vel";
					}
					echo $select;
					*/
			 ?>
		</td>
	</tr>
	<tr>
		<td><input type="radio" name="link" value="prod" />Produtos</td>
		<td><div id="div_produto" name="div_produto" >N/I</div></td>
	</tr>  

	</table>
	</td>
</tr>
-->
<?php if(!empty($idiomas)) { ?>
    <tr>
        <td colspan="2" align="center" class="titulo_noticias"><br />Demais idiomas devem ser cadastrados na próxima página<br /><br /></td>
    </tr>
<?php } ?>
<tr>
	<td colspan="2" align="center"> 
		<input type="submit" value="Salvar"/>
	</td>
</tr>
</table>
</form>

<script type="text/javascript">
    new Validation('form');
</script>