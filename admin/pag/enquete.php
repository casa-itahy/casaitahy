<?php 
/**
*	ATUALIZA
*
*	@author Ari Araujo <projetos@artwebdigital.com.br>
*	@copyright GPL ? 2010, artwebdigital.com.br
*	@version ATUALIZA 3.0
*	@created 14/11/2011
*	@modified 14/11/2011
*
*/
include("php/sessao.php");
session_write_close();

$sql = "SELECT id,pergunta,status FROM enq_perguntas";
$retorno = query($sql);



?>

<script language ="JavaScript">
function confirmar(query){
	if(window.confirm("Deseja realmente excluir esse conteúdo?"))
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
    <td height="15" align="center"><span class="msg"><?php echo @$_GET['msg']; ?></span></td>
  </tr>
  <tr>
    <td align="left" class="titulo_noticias"><table width="400" border="0" cellspacing="0" cellpadding="00">
      <tr>
        <td width="45" align="center"><a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a"><img src="img/btn_incluir.gif" alt=""  border="0" /></a></td>
        <td class="titulo_noticias">
        <a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a">
        Incluir 
        <?php
            echo $paginas['titulo'];
        ?>
        </a>
        </td>
      </tr>
    </table>      <a href="index.php?pag=40"></a></td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">
    <table width="100%" border="0" cellspacing="2" cellpadding="3">
    <tr>
		<td width="450" height="28"   bgcolor="#004882" class="texto_rodape">Pergunta</td>
		<td width="40" align="center" bgcolor="#004882" class="texto_rodape">Editar</td>
		<td width="40" align="center" bgcolor="#004882" class="texto_rodape">Vis&iacute;vel</td>
		<td width="40" align="center" bgcolor="#004882" class="texto_rodape">Excluir</td>
	</tr>  
      <?php foreach ($retorno as $x){
			  if (@$css == "#EFEFEF")
			  {
				$css = "#FFFFFF";
			  }
			  else
			  {
				$css = "#EFEFEF";
			  }
	  ?>
      <tr>
        <td bgcolor="<?php echo $css; ?>" class="texto_contato"><?php echo $x['pergunta']?></td>
        <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=e&id=<?php echo $x['id']?>"><img src="img/editar.gif" alt="Editar" width="18" height="20" border="0"></a></td>
        <?php if ($x['status']==1){ ?>
        	<td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="php/desativar.php?id=<?php echo $x['id']?>&v=0&t=<?php echo $paginas['pag_tab_id'] ?>"><img src="img/olho_visivel.gif" alt="Ativar" border="0"></a></td>
        <?php }else{ ?>
       	  <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="php/desativar.php?id=<?php echo $x['id']?>&v=1&t=<?php echo $paginas['pag_tab_id'] ?>"><img src="img/olho_oculto.gif" alt="Desativar" border="0"></a></td>
        <?php } ?>
        <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato">
        <a href="javascript:confirmar('php/excluir.php?id=<?php echo $x['id']?>&t=<?php echo $paginas['pag_tab_id'] ?>')"><img src="img/excluir.gif" alt="Excluir" width="17" height="18" border="0"> </a>
        </td>
      </tr>
   <?php } ?>      
    </table></td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
</table>
