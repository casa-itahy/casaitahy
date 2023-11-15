<?php 

  include("php/sessao.php");
  session_write_close();

  $retorno = query("SELECT id,titulo,status,created FROM categorias_noticias ORDER BY titulo ASC");

  $pagina = '37';

?>

<script language ="JavaScript">
  function confirmar(query){
      if(window.confirm("Deseja realmente EXCLUIR esta categoria \n e suas respectivas sub-categorias?")){
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
    <table width="250" border="0" cellspacing="0" cellpadding="00">
      <tr>
        <td width="45" align="center">
            <a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a">
                <img src="img/incluir.png" alt=""  border="0" />
            </a>
        </td>
        <td class="titulo_noticias" width="300">
        <a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a">
      		Incluir <?php echo $paginas['titulo']; ?>
        </a>
        </td>
      </tr>
    </table>      <a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>"></a></td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">
    <table width="100%" border="0" cellspacing="2" cellpadding="3">    
    <tr>
            <td width="450" height="28"   bgcolor="#004882" class="texto_rodape">T&iacute;tulo</td>
            <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Editar</td>
            <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Vis&iacute;vel</td>
            <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Excluir</td>
        </tr>  
     
    <?php foreach ($retorno as $res){
         echo "<tr><td bgcolor=\"$css\" class=\"texto_contato_cat\" >".$res['titulo']."</td>
                  <td align=\"center\" class=\"texto_contato_cat\">
                     <a href=\"index.php?pag=".$pagina."&tipo=e&id=".$res['id']."\">
                        <img src=\"img/editar.gif\" alt=\"Editar\" width=\"18\" height=\"20\" border=\"0\"></a>
                  </td>";
              if ($res['status']==1){
                    echo"<td align=\"center\" class=\"texto_contato_cat\">
                                    <a href=\"php/desativar.php?id=".$res['id']."&v=0&t=".$pagina."\">
                                    <img src=\"img/olho_visivel.gif\" alt=\"Ativar\" border=\"0\"></a>
                            </td>";
                }else{
                    echo"<td align=\"center\" class=\"texto_contato_cat\">
                                <a href=\"php/desativar.php?id=".$res['id']."&v=1&t=".$pagina."\">
                                <img src=\"img/olho_oculto.gif\" alt=\"Ativar\" border=\"0\"></a>
                        </td>";
                }
	  echo"<td align=\"center\" class=\"texto_contato_cat\">
                            <a href=\"javascript:confirmar('php/excluir_cat_not.php?id=".$res['id']."&t=".$pagina."')\">
                            <img src=\"img/excluir.gif\" alt=\"Excluir\" width=\"17\" height=\"18\" border=\"0\"> </a>
                      </td>
                      </tr>";
   }

?>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
</table>

