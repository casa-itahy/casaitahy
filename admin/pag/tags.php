<?php 

  include("php/sessao.php");
  session_write_close();

    $retorno = query("SELECT * FROM tags ORDER BY texto_tag ASC");

?>

<script language ="JavaScript">
function confirmar(query){
	if(window.confirm("Deseja realmente excluir esse conteúdo?")){
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
    <td align="left" class="titulo_noticias"><table width="150" border="0" cellspacing="0" cellpadding="00">
      <tr>
        <td width="45" align="center">
        <a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a">
            <img src="img/btn_incluir.gif" alt="" border="0" /></a></td>
        <td class="titulo_noticias">
        <a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a">
		<?php echo $paginas['titulo']; ?>
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
            <td width="100" height="28" align="center" bgcolor="#004882" class="texto_rodape">ID</td>
            <td width="100" align="center" bgcolor="#004882" class="texto_rodape">Tag</td>
            <td width="50" align="center" bgcolor="#004882" class="texto_rodape">Editar</td>
            <td width="50" align="center" bgcolor="#004882" class="texto_rodape">Excluir</td>
        </tr>  
      <?php foreach ($retorno as $x){
    	  if ($css == "#EFEFEF"){
          $css = "#FFFFFF";
        } else {
          $css = "#EFEFEF";
        }
      ?>
      <tr>
        <td bgcolor="<?php echo $css; ?>" align="center" class="texto_contato"><?php echo $x['id_tag']?></td>
        <td bgcolor="<?php echo $css; ?>" align="center" class="texto_contato"><?php echo $x['texto_tag']?></td>
        <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=e&id=<?php echo $x['id_tag']?>"><img src="img/editar.gif" alt="Editar" width="18" height="20" border="0"></a></td>
        <td align="center"bgcolor="<?php echo $css; ?>" class="texto_contato">
        <a href="javascript:confirmar('php/excluir-tag.php?id=<?php echo $x['id_tag']?>&t=<?php echo $paginas['pag_tab_id'] ?>&tipo=p')"><img src="img/excluir.gif" alt="Excluir" width="17" height="18" border="0"></a></td>
      </tr>
      <?php }?>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
</table>