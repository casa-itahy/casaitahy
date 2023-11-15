<?php 
include("php/sessao.php");
session_write_close();

$sql = "SELECT * FROM recados WHERE id_noticia = 0 AND id_album = 0 ORDER BY id DESC ";
$retorno = query($sql);

?>

<script language ="JavaScript">
function confirmar(query){
	if(window.confirm("Deseja realmente excluir este comentário?"))
	{
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
    <td height="15" align="center"><span class="msg"><?php echo $_GET['msg']; ?></span></td>
  </tr>
  <tr>
    <td align="left" class="titulo_noticias"><h1>Recados deixados pelos visitantes</h1><table width="150" border="0" cellspacing="0" cellpadding="00">
      <tr>
        <td width="45" align="center">

        </td>
        <td class="titulo_noticias">
        	
        </td>
      </tr>
    </table>      <a href="index.php?pag=50"></a></td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">
    <table width="100%" border="0" cellspacing="2" cellpadding="3">
          <tr>
            <td width="400" height="28"   bgcolor="#004882" class="texto_rodape">T&iacute;tulo</td>
            <td width="50" align="center" bgcolor="#004882" class="texto_rodape">Editar</td>
            <td width="50" align="center" bgcolor="#004882" class="texto_rodape">Vis&iacute;vel</td>
            <td width="50" align="center" bgcolor="#004882" class="texto_rodape">Excluir</td>
            <td width="100" align="center" bgcolor="#004882" class="texto_rodape">Data</td>
        </tr>  
      <?php foreach ($retorno as $x){
		   if ($css == "#EFEFEF")
			  {
				$css = "#FFFFFF";
			  }
			  else
			  {
				$css = "#EFEFEF";
			  }
	  ?>
      <tr>
        <td bgcolor="<?php echo $css; ?>" class="texto_contato"><?php echo $x['titulo']." <i>por</i> <b>".$x['autor']."</b>"?> </td>
        <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=e&id=<?php echo $x['id']?>"><img src="img/editar.gif" border="0"></a></td>
        <?php if ($x['status']==1){ ?>
        	<td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="php/desativar.php?id=<?php echo $x['id']?>&amp;v=0&amp;t=33"><img src="img/olho_visivel.gif" alt="Ativar" border="0"></a></td>
        <?php } else { ?>
       	  <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="php/desativar.php?id=<?php echo $x['id']?>&amp;v=1&amp;t=33"><img src="img/olho_oculto.gif" alt="Ativar" border="0"></a></td>
        <?php } ?>
        <td align="center"bgcolor="<?php echo $css; ?>" class="texto_contato">
        <a href="javascript:confirmar('php/excluir.php?id=<?php echo $x['id']?>&t=33')"><img src="img/excluir.gif" alt="Excluir" width="17" height="18" border="0"></a></td>
        <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato">        
		<?php 
            echo $data = $x['data'];
		?>        </td>
        </tr>
      <?php }?>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
</table>

