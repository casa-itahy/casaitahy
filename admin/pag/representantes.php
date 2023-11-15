<?php 
include_once("php/sessao.php");
session_write_close();
include_once("includes/db.php");
	
$sql = "SELECT id,nome, login FROM associados WHERE tipo=2 ORDER BY nome ASC ";
$retorno = query($sql);

?>

<script language ="JavaScript">
function confirmar(query){
	if(window.confirm("Deseja realmente excluir esse distribuidor?")){
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
    <td height="15" align="center"><p class="msg"><?php echo $_GET['msg']; ?></p></td>
  </tr>
  <tr>
    <td align="left" class="titulo_noticias">
    	<table width="100%" border="0" cellspacing="0" cellpadding="00">
          <tr>
            <td width="45" align="center">
                <a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a">
                    <img src="img/incluir.png" alt=""  border="0" width="45" height="50" border="0" />
                </a>
            </td>
            <td class="titulo_noticias">
                <a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a">
                    <?php echo $paginas['titulo'];
                          @session_write_close; ?>
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
            <td width="300" height="28"   bgcolor="#004882" class="texto_rodape">Nome</td>
            <td width="80" align="center" bgcolor="#004882" class="texto_rodape">Editar</td>
            <td width="80" align="center" bgcolor="#004882" class="texto_rodape">Excluir</td>
     </tr>
	<?php 
          foreach ($retorno as $x){
		  if ($css == "#EFEFEF"){
                        $css = "#FFFFFF";
                  }else{
                        $css = "#EFEFEF";
                  }
	?>
          <tr>
            <td bgcolor="<?php echo $css; ?>" class="texto_contato"><?php echo $x['nome']?></td>
            <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato">
                    <a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=e&amp;id=<?php echo $x['id']?>">
                        <img src="img/editar.gif" alt="Editar" width="18" height="20" border="0">                        
                    </a>
            </td>
            <td align="center"bgcolor="<?php echo $css; ?>" class="texto_contato">
                 <a href="javascript:confirmar('php/excluir.php?id=<?php echo $x['id']?>&amp;t=<?php echo $paginas['pag_tab_id'] ?>')">
                     <img src="img/excluir.gif" alt="Excluir" width="17" height="18" border="0">
                 </a>
            </td>
          </tr>
      <?php }?>
    </table>
    </td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
</table>