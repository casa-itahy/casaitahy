<?php 
include("php/sessao.php");
session_write_close();

if(isset($_POST['buscar'])){
  $buscar = $_POST['buscar'];
} else if(isset($_GET['buscar'])) {
  $buscar = $_GET['buscar'];
} else {
  $buscar = '';
}

$onde = '';

#----------------------------------------------------------#
if($buscar){
        $sql = "SELECT albuns.id,albuns.titulo,albuns.status FROM albuns 
                    LEFT JOIN modulos m ON(albuns.tipo=m.modulo_gemeo)
                WHERE m.pag_tab_id='".$pag."' AND albuns.titulo LIKE '%$buscar%' ORDER BY albuns.created DESC ";
        $retorno = query($sql);
}else{  
        $sql = "SELECT albuns.id,albuns.titulo,albuns.status,albuns.tipo FROM albuns 
               WHERE albuns.id != 4 ORDER BY albuns.created DESC";
        $retorno = query($sql);
}

  ##### VERIFICA PAGINAÇÃO #######
  $registros_pagina = "25";

  if(isset($_GET["lista"])) {
    $lista = (int)$_GET["lista"];
    if(!$lista){
      $pc = "1";
    }else{
      $pc = $lista;
    }
  } else {
    $pc = "1";
  }

	$inicio = $pc - 1;
	$inicio = $inicio * $registros_pagina;

	$retorno = query("$sql LIMIT $inicio, $registros_pagina");
	$todos = query("$sql");
  if($todos){
    $tr = count($todos);
  } else {
    $tr = 0;
  }
	$tp = $tr / $registros_pagina;

  //voltar sem perder filtros ....
  if(isset($_GET['lista'])) {
    $getLista = $_GET['lista'];
  } else {
    $getLista = '';
  }
  
  if(isset($_GET['o'])) {
    $geto = $_GET['o'];
  } else {
    $geto = '';
  }
  
  if(isset($_GET['buscar'])) {
    $getBuscar = $_GET['buscar'];
  } else {
    $getBuscar = '';
  }

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
    <td align="left" class="titulo_noticias">
     <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="45" align="center"><a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a"><img src="img/incluir.png" alt=""  border="0" /></a></td>
          <td class="titulo_noticias" width="200">
            <a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a">
              Incluir <?php echo $paginas['titulo']; ?>
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
            <td colspan="6" align="center" class="valor_prod">
                <?php

                $tp = ceil($tp);
                if($pc > 1) {
                        $anterior = $pc - 1;
                        echo "<a href=\"index.php?pag=".$paginas['pag_tab_id']."&tipo=p&lista=$anterior&o=$onde&buscar=$buscar\">[Anterior]</a> ";
                }
                for($i=$pc-5;$i<$pc;$i++)
                {
                        if($i <= 0) {
                        }
                        else {
                                echo "<a href=\"index.php?pag=".$paginas['pag_tab_id']."&tipo=p&lista=$i&o=$onde&buscar=$buscar\">";
                                if($i=="$pc") {
                                        echo "<b>[$i]</b>";
                                }
                                else {
                                        echo "[$i]";
                                }
                                echo "</a> ";
                        }
                }
                for($i=$pc;$i<=$pc+5;$i++) {
                        if($i==$tp) {
                                echo "<a href=\"index.php?pag=".$paginas['pag_tab_id']."&tipo=p&lista=$i&o=$onde&buscar=$buscar\">";
                                if($i=="$pc") {
                                        echo "<b>[$i]</b>";
                                }
                                else {
                                        echo "[$i]";
                                }

                                echo "</a> ";
                                break;
                        }
                        else {
                                echo "<a href=\"index.php?pag=".$paginas['pag_tab_id']."&tipo=p&lista=$i&o=$onde&buscar=$buscar\">";
                                if($i=="$pc") {
                                        echo "<b>[$i]</b>";
                                }
                                else {
                                        echo "[$i]";
                                }
                                echo "</a> ";

                                if($i==$pc+5 && $tp>$pc+5) {
                                        echo " ... <a href=\"index.php?pag=".$paginas['pag_tab_id']."&tipo=p&lista=$tp&o=$onde&buscar=$buscar\">[$tp]</a>";
                                }
                        }
                }
                if($pc<$tp) {
                        $proxima = $pc + 1;
                        echo " <a href=\"index.php?pag=".$paginas['pag_tab_id']."&tipo=p&lista=$proxima&o=$onde&buscar=$buscar\">[Pr&oacute;xima]</a>";
                }

         ?>
         </td>
         </tr>
         
  <tr>
    <td align="center" class="titulo_noticias">
    <table width="100%" border="0" cellspacing="2" cellpadding="3">
        <tr>
            <td width="450" height="28"   bgcolor="#004882" class="texto_rodape">T&iacute;tulo</td>
            <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Editar</td>
            <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Vis&iacute;vel</td>
            <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Excluir</td>
<!--             <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Sobe</td>
            <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Desce</td> -->
        </tr>  
          <?php foreach ($retorno as $x){
                  if ($css == "#EFEFEF"){
                        $css = "#FFFFFF";
                  }else{
                        $css = "#EFEFEF";
                  }
                  $categ = query("SELECT titulo FROM categorias_noticias WHERE id= '".$x['tipo']."'");

	  ?>
          <tr>
                <td bgcolor="<?php echo $css; ?>" class="texto_contato"><?php echo $x['titulo']?></td>
                <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=e&id=<?php echo $x['id']?>&lista=<?php echo $getLista ?>&o=<?php echo $geto ?>&buscar=<?php echo $getBuscar ?>"><img src="img/editar.gif" alt="Editar" width="18" height="20" border="0"></a></td>
                <?php if ($x['status']==1){ ?>
                        <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="php/desativar.php?id=<?php echo $x['id']?>&v=0&t=<?php echo $paginas['pag_tab_id'] ?>&lista=<?php echo $getLista ?>&o=<?php echo $geto ?>&buscar=<?php echo $getBuscar ?>"><img src="img/olho_visivel.gif" alt="Ativar" border="0"></a></td>
                <?php }else{ ?>
                  <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="php/desativar.php?id=<?php echo $x['id']?>&v=1&t=<?php echo $paginas['pag_tab_id'] ?>&lista=<?php echo $getLista ?>&o=<?php echo $geto ?>&buscar=<?php echo $getBuscar ?>"><img src="img/olho_oculto.gif" alt="Desativar" border="0"></a></td>
                <?php } ?>
                <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato">
                <a href="javascript:confirmar('php/excluir.php?id=<?php echo $x['id']?>&t=<?php echo $paginas['pag_tab_id'] ?>&lista=<?php echo $getLista ?>&o=<?php echo $geto ?>&buscar=<?php echo $getBuscar ?>')"><img src="img/excluir.gif" alt="Excluir" width="17" height="18" border="0"> </a>
                </td>
<!--                 <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="php/sobe.php?id=<?php echo $x['id']?>&t=<?php echo $paginas['pag_tab_id'] ?>&lista=<?php echo $getLista ?>&o=<?php echo $geto ?>&buscar=<?php echo $getBuscar ?>"><img src="img/sobe.gif" alt="Sobe" width="14" height="20" border="0"></a></td>
                <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="php/desce.php?id=<?php echo $x['id']?>&t=<?php echo $paginas['pag_tab_id'] ?>&lista=<?php echo $getLista ?>&o=<?php echo $geto ?>&buscar=<?php echo $getBuscar ?>"><img src="img/desce.gif" alt="Desce" width="14" height="20" border="0"></a></td> -->
          </tr>
   <?php } ?>  
         
       </table>
    </td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
</table>

