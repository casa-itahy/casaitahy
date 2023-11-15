<?php 

  include("php/sessao.php");
  session_write_close();

  $sql = "SELECT pl.id, pl.titulo, cs.titulo AS solucao FROM plano_individual pl LEFT JOIN categorias_subcat cs ON(cs.id = pl.solucao) ORDER BY pl.solucao,pl.posicao ASC ";
  $retorno = query($sql);

?>

<style>
ul {
  margin: 0;
}

#contentLeft {
  float: left;
  width: 970px;
  margin:0;
}

#contentLeft li {
  list-style: none;
  margin: 0 0 0 -40px;
  color:#000;
}
.ui-sortable{
  padding: 0;
}
</style>

<script type="text/javascript" src="js/drag/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/drag/jquery-ui-1.7.1.custom.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){ 
               
  $(function() {
    $("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
      var order = $(this).sortable("serialize") + '&action=updateRecordsListings'; 
      $.post("php/ordena_planos.php", order, function(theResponse){
        //$("#contentLeft").html(theResponse);
        if(theResponse) {
          window.location.reload();
          //alert(theResponse);
        }
      });                                
    }                 
    });
  });

}); 
</script>

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
            <img src="img/incluir.png" alt="" border="0" /></a></td>
        <td class="titulo_noticias">
        <a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a">
        Incluir
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
            <td width="400" height="28"   bgcolor="#004882" class="texto_rodape">T&iacute;tulo</td>
            <td width="400" height="28"   bgcolor="#004882" class="texto_rodape">Solução</td>
            <td width="50" align="center" bgcolor="#004882" class="texto_rodape">Editar</td>
            <td width="50" align="center" bgcolor="#004882" class="texto_rodape">Excluir</td>
        </tr>
      </table>
      <div id="contentLeft">
        <ul>
      <?php foreach ($retorno as $x){
      if ($css == "#EFEFEF"){
                        $css = "#FFFFFF";
                  }else{
                        $css = "#EFEFEF";
                  }
    ?>

          <div id="recordsArray_<?php echo $x['id'] ?>" style="cursor:move;" title="Arraste para mover">
            <div id="listaProdutosLista">
              <div id="listaProdutosListaNome" style="width:415px; text-align:left; padding-left:7px; background:<?php echo $css ?>"><?php echo $x['titulo'] ?></div>
              <div id="listaProdutosListaNome" style="width:415px; text-align:left; padding-left:7px; background:<?php echo $css ?>"><?php echo $x['solucao'] ?></div>
              <div id="listaProdutosListaNome" style="width:57px; background:<?php echo $css ?>">
                <a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=e&id=<?php echo $x['id']?>"><img src="img/editar.gif" alt="Editar" width="18" height="20" border="0"></a>
              </div>
              <div id="listaProdutosListaNome" style="width:57px; background:<?php echo $css ?>">
                <a href="javascript:confirmar('php/excluir.php?id=<?php echo $x['id']?>&t=<?php echo $paginas['pag_tab_id'] ?>&tipo=p')"><img src="img/excluir.gif" alt="Excluir" width="17" height="18" border="0"></a>
              </div>
            </div>
          </div>
        <?php }?>
        </ul>
      </div>
    </td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
</table>

