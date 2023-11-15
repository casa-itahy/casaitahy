<?php 
	include("php/sessao.php");
	$banners = query("SELECT b.*,g.nome as nome_grupo FROM banners as b LEFT JOIN grupo_banners as g ON (g.id = b.grupo) ORDER BY grupo, ordem");
?>

<script language ="JavaScript">
function confirmar(query){
	if (window.confirm("Deseja realmente excluir esse banner?")) {
            window.location= query;
            return true;
	}
}
</script>

<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="15" align="center"><span class="msg"><?php echo @$_GET['msg']; ?></span></td>
  </tr>
  <tr>
    <td align="left" class="titulo_noticias"><table width="150" border="0" cellspacing="0" cellpadding="00">
      <tr>
        <td width="45" align="center">
			<a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a">
				<img src="img/incluir.png" alt="" border="0" />
			</a>
		</td>
        <td class="titulo_noticias">
			<a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a">
			Incluir
			<?php         
				echo $paginas['titulo'];
				session_write_close();
			?>
			</a>
        </td>
      </tr>
    </table> 
    </td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">
    <table width="100%" border="0" cellspacing="2" cellpadding="3">
	<tr>
		<td width="200" height="28"   bgcolor="#004882" class="texto_rodape">Miniatura</td>
		<td width="200" height="28"   bgcolor="#004882" class="texto_rodape">T&iacute;tulo</td>
		<td width="100" align="center" bgcolor="#004882" class="texto_rodape">Grupo</td>
		<td width="50" align="center" bgcolor="#004882" class="texto_rodape">Editar</td>
		<td width="50" align="center" bgcolor="#004882" class="texto_rodape">Vis&iacute;vel</td>
		<td width="50" align="center" bgcolor="#004882" class="texto_rodape">Excluir</td>
		<td width="50" align="center" bgcolor="#004882" class="texto_rodape">Sobe</td>
		<td width="50" align="center" bgcolor="#004882" class="texto_rodape">Desce</td>
	</tr>  
<?php if ($banners) { $css = ''; ?>
      <?php 
	  $primGrupo = $banners['0']['grupo'];
	  ?>
			<tr>
				<td bgcolor="#004882" colspan='10' class="texto_rodape"><?php echo $banners['0']['nome_grupo'];?></td>
			</tr>
	  <?php
	  
	  foreach ($banners as $x) {
		  if ($css == "#EFEFEF") {
				$css = "#FFFFFF";
		  } else {
				$css = "#EFEFEF";
		  }
		  
		  if ($x['grupo'] != $primGrupo) {
		?>
				<tr>
					<td bgcolor="#004882" colspan='10' class="texto_rodape"><?php echo $x['nome_grupo'];?></td>
				</tr>
		<?php
				$primGrupo = $x['grupo'];
		  }
	  ?>
      <tr>
		<td bgcolor="<?php echo $css; ?>" class="texto_contato">
			<img src="imagens/banners/grupo<?php echo $x['grupo']?>/thumb_<?php echo $x['src']?>" style="max-width:250px;" />
		</td>
		
        <td bgcolor="<?php echo $css; ?>" class="texto_contato">
			<?php echo $x['nome']?>
		</td>
		
		<td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato">
			<?php echo $x['nome_grupo']; ?>
        </td>
		
        <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato">
			<a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=e&id=<?php echo $x['id']?>">
				<img src="img/editar.gif" alt="Editar" width="18" height="20" border="0">
			</a>
		</td>
		
		<?php if ($x['status']==1){ ?>
        	<td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato">
				<a href="php/desativar.php?id=<?php echo $x['id']?>&amp;v=0&amp;t=<?php echo $paginas['pag_tab_id'] ?>&tipo=p">
					<img src="img/olho_visivel.gif" alt="Ativar" border="0">
				</a>
			</td>
        <?php } else { ?>
			<td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato">
				<a href="php/desativar.php?id=<?php echo $x['id']?>&amp;v=1&amp;t=<?php echo $paginas['pag_tab_id'] ?>&tipo=p">
					<img src="img/olho_oculto.gif" alt="Desativar" border="0">
				</a>
			</td>
        <?php } ?>
		
        <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato">
			<a href="javascript:confirmar('php/excluir_banner.php?id=<?php echo $x['id']?>')">
				<img src="img/excluir.gif" alt="Excluir" width="17" height="18" border="0">
			</a>
		</td>
		<td align="center" class="texto_contato" bgcolor="<?php echo $css; ?>">
			<a href="php/sobeB.php?id=<?php echo $x['id']; ?>&t=20">
				<img src="img/sobe.gif" alt="Sobe" width="14" height="20" border="0">
			</a>
		</td>
		<td align="center" class="texto_contato" bgcolor="<?php echo $css; ?>">
			<a href="php/desceB.php?id=<?php echo $x['id']; ?>&t=20">
				<img src="img/desce.gif" alt="Desce" width="14" height="20" border="0">
			</a>
		</td>
        
      </tr>
      <?php } ?>
<?php } ?>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
</table>

