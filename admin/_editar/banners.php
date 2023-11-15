<?php 

	$id = $_GET['id'];
	
	$grupos = query('SELECT id, nome FROM grupo_banners WHERE status = 1');
	
	$banner = query('SELECT * FROM banners WHERE id =' . $id);
	$banner = $banner['0'];

	$idiomas = query("SELECT * FROM idiomas WHERE status=1 AND sigla!='Port'");

?>

<script type="text/javascript" src="js/validation.js"></script>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/banners.js"></script>

<form action="_update/banners.php" enctype="multipart/form-data" method="post" id="form" >
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" >
<input type="hidden" id="grupo" name="grupo" value="<?php echo $banner['grupo']; ?>" >
<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
<tr>
	<td height="30" colspan="2" align="center">&nbsp;</td>
</tr>
<tr>
	<td colspan="2" align="center">
		<h1>Editar Banner</h1>
	</td>
</tr>
<tr>
	<td width="150" class="titulo_noticias">T&iacute;tulo</td>
	<td class="titulo_noticias">
		<label>
			<input name="titulo" type="text" id="titulo" size="70" value="<?php echo $banner['nome']; ?>"  class="required">
		</label>
    </td>    
</tr>
<tr style="display:none;">
	<td class="titulo_noticias">Observações</td>
	<td class="titulo_noticias">
		Colocar o texto entre as tags &lt;strong&gt;Exemplo&lt;/strong&gt; para que o mesmo apareça em outra cor no título do banner.
	</td>
</tr>
<tr>
	<td class="titulo_noticias">Imagem</td>
	<td class="titulo_noticias">
		<?php
			$caminho = "imagens/banners/grupo".$banner['grupo']."/thumb_".$banner['src'];
			if (!empty($banner['src'])) {
		?>
			<img style="max-width: 220px;" src="<?php echo $caminho; ?>"/>
			&nbsp;
			<a href="php/apagarBanner.php?g=<?php echo $banner['grupo']; ?>&id=<?php echo $id; ?>&pag=<?php echo $paginas['pag_tab_id']; ?>">
				Apagar
			</a>
		<?php
			} else {
		?>
			<input name="imagem" type="file" id="imagem" size="46">			
		<?php } ?>
	</td>    
</tr>
<tr>
	<td class="titulo_noticias">Tamanho</td>
	<td class="titulo_noticias">
		Parceiros: A imagem deve ter 150 pixels de largura e ser retangular.<br />
		Cases: A imagem deve ser quadrada com 480 pixels.<br />
	</td>
</tr>
<tr style="display:none;">
	<td class="titulo_noticias">Grupo</td>
	<td class="titulo_noticias">
		<select id='grupo' name="grupo" class="validate-selection">
			<option value="0"> -- Escolha --</option>
			<?php foreach($grupos as $g) { ?>
				<option value="<?php echo $g['id']; ?>"
					<?php if ($g['id'] == $banner['grupo']) echo "selected='selected'"; ?>
				> <?php echo $g['nome']; ?> </option>
			<?php } ?>
		</select>
	</td>    
</tr>
<tr <?php if ($banner['grupo'] == 1): ?>style="display:none;"<?php endif ?>>
	<td class="titulo_noticias">Número</td>
	<td class="titulo_noticias">
		<input size="55" name="texto" value="<?php echo $banner['texto']; ?>" maxlength="2" />
	</td>
</tr>
<tr <?php if ($banner['grupo'] == 1): ?>style="display:none;"<?php endif ?>>
	<td class="titulo_noticias">Texto Inferior</td>
	<td class="titulo_noticias">
		<input name="descricao" type="text" id="descricao" size="70" value="<?php echo $banner['descricao']; ?>" />
	</td>
</tr>
<tr style="display: none;">
	<td class="titulo_noticias">Link</td>
	<td class="titulo_noticias">
		<input name="urllink" type="text" id="urllink" size="70" value="<?php echo $banner['url_link']; ?>" >
	</td>
</tr>
<tr style="display:none;">
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
<tr>
	<td colspan="2" align="center"> 
		<input type="submit" value="Salvar"/>
	</td>
</tr>
</form>

<?php if(!empty($idiomas) AND $banner['grupo'] < 4) { ?>
	<?php foreach($idiomas as $idioma) { 
		$dados_idioma = query("SELECT * FROM banners_idioma WHERE idioma_id = ".$idioma['id']." AND banner_id = ".$id);
		if(isset($dados_idioma[0])) {
			$dados_idioma = $dados_idioma[0];
		} else{
			$dados_idioma = '';
		}
	?>
        <form action="_update/banners-idioma.php" enctype="multipart/form-data" method="post" id="form" >
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" id="grupo" name="grupo" value="<?php echo $banner['grupo']; ?>" >
            <input type="hidden" id="idioma" name="idioma" value="<?php echo $idioma['id']; ?>" />
            <?php if($dados_idioma) { ?>
                <input type="hidden" id="temBanner" name="temBanner" value="sim" />
			<?php } else { ?>
                <input type="hidden" id="temBanner" name="temBanner" value="nao" />
			<?php } ?>
            <tr>
                <td colspan="2" class="titulo_noticias" align="center">
                    <h1><?php echo $idioma['nome']; ?></h1>
                </td>
            </tr>
            <tr>
                <td width="150" class="titulo_noticias">T&iacute;tulo</td>
                <td class="titulo_noticias">
                    <label>
                    	<?php if ($dados_idioma) { ?>
	                        <input name="titulo" type="text" id="titulo" size="70" value="<?php echo $dados_idioma['nome']; ?>" />
                    	<?php } else { ?>
	                        <input name="titulo" type="text" id="titulo" size="70" />
                    	<?php } ?>
                    </label>
                </td>    
            </tr>
            <tr>
                <td width="150" class="titulo_noticias">Texto</td>
                <td class="titulo_noticias">
                	<?php if ($dados_idioma) { ?>
                        <textarea name="texto" class="editor"><?php echo $dados_idioma['texto']; ?></textarea>
                	<?php } else { ?>
                        <textarea name="texto" class="editor"></textarea>
                	<?php } ?>
                </td>    
            </tr>
            <tr>
                <td class="titulo_noticias">Imagem</td>
                <td class="titulo_noticias">
                	<?php if ($dados_idioma) { ?>
	                    <?php
	                        $caminho = "imagens/banners/grupo".$banner['grupo']."/thumb_".$dados_idioma['src'];
	                        if (!empty($dados_idioma['src'])) {
	                    ?>
	                        <img style="max-width:200px;" src="<?php echo $caminho; ?>"/>
	                        &nbsp;
	                        <a href="php/apagarBannerIdiomas.php?g=<?php echo $banner['grupo']; ?>&id=<?php echo $id; ?>&pag=<?php echo $paginas['pag_tab_id']; ?>&idioma=<?php echo $idioma['id']; ?>">
	                            Apagar
	                        </a>
	                    <?php } else { ?>
	                        <input name="imagem" type="file" id="imagem" size="46" />
	                    <?php } ?>
	              	<?php } else { ?>
                        <input name="imagem" type="file" id="imagem" size="46" />
	              	<?php } ?>
                </td>    
            </tr>
			<tr <?php if($banner['grupo'] != 1) { echo "style='display: none;'"; } ?>>
				<td class="titulo_noticias">Texto do Botão</td>
				<td class="titulo_noticias">
					<input name="descricao" type="text" id="descricao" size="70" <?php if ($dados_idioma) { ?>value="<?php echo $dados_idioma['descricao']; ?>"<?php } ?> />
				</td>
			</tr>
            <tr>
                <td colspan="2" align="center" class="titulo_noticias"> 
                    <input type="submit" value="Salvar Banner <?php echo $idioma['nome']; ?>"/>
                </td>
            </tr>
        </form>
	<?php } ?>

    <tr>
        <td colspan="2" align="center" class="titulo_noticias">
            <a href="index.php?pag=20&tipo=p" style="width:150px; height:30px; line-height:30px; display:block; color:#FFF; background:#004B85; margin:20px 0;">Concluir</a>
        </td>
    </tr>
<?php } ?>

</table>

<script type="text/javascript">
    new Validation('form');
</script>