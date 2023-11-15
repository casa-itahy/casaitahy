<?php 

    $tipo = query("SELECT modulo_gemeo FROM modulos WHERE pag_tab_id=".$pag);
    $tipo = $tipo[0]['modulo_gemeo'];

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
		Incluir        
		<?php
                echo $paginas['titulo'];                
                    session_write_close();
		?>
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
            <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Sobe</td>
            <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Desce</td>
        </tr>  
     <?php
function lista($pagina, $tipo){
        $categoria_array = array();
        /*####################################
           * ##### BUCA TODAS AS CATEGORIAS PAI ########
           ####################################*/
        $sql = "SELECT DISTINCT(cs.id),cs.titulo,cs.status,cs.posicao
                FROM categorias_subcat cs
                RIGHT JOIN cat_subcat_nivel csn ON (cs.id = csn.cat_pai_id)
                WHERE csn.cat_filho_id IS NULL 
                AND csn.cat_neto_id IS NULL
                AND csn.sub_cat_id IS NULL
                AND cs.tipo = $tipo
                ORDER BY cs.posicao";
        $categorias = query($sql);
        
    $cont=0;
    foreach ($categorias as $categoria){
        $categoria_array[$cont]['titulo'] = '->'.$categoria['titulo'];
        $categoria_array[$cont]['id'] = $categoria['id'];
        $categoria_array[$cont]['status'] = $categoria['status'];
        $categoria_array[$cont]['idPai'] = 0;
        $cont++;
        /*##############################################
         *####### BUCA TODAS AS CATEGORIAS FILHO ########
         ################################################*/
         $sql ="SELECT c.id, csn.cat_filho_id, c.titulo, c.status
                                   FROM categorias_subcat c
                                   LEFT JOIN cat_subcat_nivel csn ON (c.id=csn.cat_filho_id)
                                   WHERE csn.cat_pai_id='".$categoria['id']."'
                                   AND csn.cat_neto_id IS NULL
                                   ORDER BY c.posicao ASC";
         $catFilho_array=query($sql);
         
         if(count($catFilho_array)>0){
                $espaco = "&nbsp;&nbsp;&nbsp;&nbsp;";
                foreach ($catFilho_array as $catFilho){
                    $categoria_array[$cont]['titulo'] = $espaco.'-->'.$catFilho['titulo'];
                    $categoria_array[$cont]['id'] = $categoria['id'].'-'.$catFilho['id'];
                    $categoria_array[$cont]['status'] = $catFilho['status'];
                    $categoria_array[$cont]['idPai'] =  $categoria['id'];
                    $cont++;
                    /*##############################################
                     *####### BUCA TODAS AS CATEGORIAS NETO ########
                     ################################################*/
                     $sql=("SELECT c.id, csn.cat_filho_id, c.titulo, c.status
                                               FROM categorias_subcat c
                                               LEFT JOIN cat_subcat_nivel csn ON (c.id=csn.cat_neto_id)
                                               WHERE csn.cat_filho_id='".$catFilho['cat_filho_id']."'
                                               ORDER BY c.posicao ASC");
                                               
                     $catNeto_array = query($sql);
                     if(count($catNeto_array)>0){
                          foreach ($catNeto_array as $catNeto){
                            $categoria_array[$cont]['titulo'] = $espaco.$espaco.'--->'.$catNeto['titulo'];
                            $categoria_array[$cont]['id'] = $categoria['id'].'-'.$catFilho['id'].'-'.$catNeto['id'];
                            $categoria_array[$cont]['status'] = $catNeto['status'];
                            $categoria_array[$cont]['idPai'] =  $categoria['id'];
                            $cont++;
                          }                         
                     }
                }
         }
    }    
    foreach ($categoria_array as $res){        
         echo "<tr><td class=\"texto_contato_cat\" >".$res['titulo']."</td>
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
                            <a href=\"javascript:confirmar('php/excluir_prod_cat.php?id=".$res['id']."&t=".$pagina."')\">
                            <img src=\"img/excluir.gif\" alt=\"Excluir\" width=\"17\" height=\"18\" border=\"0\"> </a>
                      </td>
                      <td align=\"center\" class=\"texto_contato_cat\">
                            <a href=\"php/sobeC.php?id=".$res['id']."&t=".$pagina."\">
                            <img src=\"img/sobe.gif\" alt=\"Sobe\" width=\"14\" height=\"20\" border=\"0\"></a>
                      </td>
                      <td align=\"center\" class=\"texto_contato_cat\">
                                <a href=\"php/desceC.php?id=".$res['id']."&t=".$pagina."\">
                                <img src=\"img/desce.gif\" alt=\"Desce\" width=\"14\" height=\"20\" border=\"0\"></a>
                      </td>
                      </tr>";
   }
}
   lista($paginas['pag_tab_id'], $tipo);
?>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
</table>

