<?php 

    include_once("php/sessao.php");
    session_write_close();
    $sql = "SELECT  paginas.id,
                paginas.titulo, 
                paginas.tipo, 
                paginas.status,
				paginas.posicao,
                m.titulo AS nome_tipo
            FROM paginas  
            LEFT JOIN modulos m ON (paginas.tipo = m.id)
            ORDER BY posicao";
    $retorno = query($sql);
	
?>

<script language ="JavaScript">
function confirmar(query){
	if(window.confirm("Deseja realmente excluir esse conteúdo?")){
            window.location= query;
            return true;
	}
}
</script>
<style>
ul {
	margin: 0;
}

#contentLeft {
	float: left;
	width: 950px;
}

#contentLeft li {
	list-style: none;
	margin: 0 0 0 -40px;
	color:#000;
}


</style>

<script type="text/javascript" src="js/drag/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/drag/jquery-ui-1.7.1.custom.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){ 
	$(function() {
		$("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings'; 
			$.post("php/ordena_itens.php", order, function(theResponse){
				$("#contentLeft").html(theResponse);
			}); 															 
		}								  
		});
	});

});	
</script>


<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr> 
  <tr>
    <td height="15" align="center"><p class="msg"><?php echo $_GET['msg']; ?></p></td>
  </tr>
  <tr>
    <td align="left" class="titulo_noticias"><table width="150" border="0" cellspacing="0" cellpadding="00">
      <tr>
        <td width="45" align="center">
        <a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a">
        	<img src="img/incluir.png" alt="" border="0" >
        </a>
        </td>
        <td class="titulo_noticias">
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
    <td align="center" class="titulo_noticias">
    <table width="100%" border="0" cellspacing="2" cellpadding="3">
      <tr>
            <td width="254" height="28"   bgcolor="#004882" class="texto_rodape">T&iacute;tulo</td>
            <td width="90" align="center" bgcolor="#004882" class="texto_rodape">Conte&uacute;do</td>
            <td width="50" align="center" bgcolor="#004882" class="texto_rodape">Editar</td>
            <td width="50" align="center" bgcolor="#004882" class="texto_rodape">Vis&iacute;vel</td>
            <td width="50" align="center" bgcolor="#004882" class="texto_rodape">Excluir</td>
        </tr>
	</table>
		<div id="contentLeft">
		<ul>
			<?php
			
            function lista($pagina){
                   $pagina_array = array();
                    
                   /*############################################
                   * ##### BUSCA TODAS AS CATEGORIAS PAI ########
                   #############################################*/
                    $sql = "SELECT DISTINCT(p.id),p.titulo,p.status,p.posicao,p.tipo,m.titulo as nome_tipo
                            FROM paginas p
                            LEFT JOIN modulos m ON(p.tipo=m.id)
                            RIGHT JOIN pag_subpag_nivel csn ON (p.id = csn.pag_pai_id)
                            WHERE csn.pag_filho_id IS NULL 
                            AND csn.pag_neto_id IS NULL                            
                            ORDER BY p.posicao";
                    $paginas = query($sql);
                    
                    

                $cont=0;
                foreach ($paginas as $item){
                    $pagina_array[$cont]['titulo'] = '->'.$item['titulo'];
                    $pagina_array[$cont]['id'] = $item['id'];
                    $pagina_array[$cont]['nome_tipo'] = $item['nome_tipo'];
                    $pagina_array[$cont]['status'] = $item['status'];
                    $pagina_array[$cont]['idPai'] = 0;
                    $cont++;
                    /*##############################################
                     *####### BUCA TODAS AS CATEGORIAS FILHO ########
                     ################################################*/
                     $sql ="SELECT p.id, csn.pag_filho_id, p.titulo,p.posicao, p.status, m.titulo as nome_tipo
                                               FROM paginas p
                                               LEFT JOIN modulos m ON(p.tipo=m.id)
                                               LEFT JOIN pag_subpag_nivel csn ON (p.id=csn.pag_filho_id)
                                               WHERE csn.pag_pai_id='".$item['id']."'
                                               AND csn.pag_neto_id IS NULL
                                               ORDER BY p.posicao ASC";
                     $catFilho_array=query($sql);
                     
                     //echo ($sql);die();
                     if(count($catFilho_array)>0){
                            $espaco = "&nbsp;&nbsp;&nbsp;&nbsp;";
                            foreach ($catFilho_array as $catFilho){
                                $pagina_array[$cont]['titulo'] = $espaco.'-->'.$catFilho['titulo'];
                                $pagina_array[$cont]['id'] = $item['id'].'-'.$catFilho['id'];
                                $pagina_array[$cont]['nome_tipo'] = $catFilho['nome_tipo'];
                                $pagina_array[$cont]['status'] = $catFilho['status'];
                                $pagina_array[$cont]['idPai'] =  $item['id'];
                                $cont++;
                                /*##############################################
                                 *####### BUCA TODAS AS CATEGORIAS NETO ########
                                 ################################################*/
                                 $sql=("SELECT p.id, csn.pag_filho_id, p.posicao, p.titulo, p.status, m.titulo as nome_tipo
                                                           FROM paginas p
                                                           LEFT JOIN modulos m ON(p.tipo=m.id)
                                                           LEFT JOIN pag_subpag_nivel csn ON (p.id=csn.pag_neto_id)
                                                           WHERE csn.pag_filho_id='".$catFilho['pag_filho_id']."'
                                                           ORDER BY p.posicao ASC");

                                 $catNeto_array = query($sql);
                                 if(count($catNeto_array)>0){
                                      foreach ($catNeto_array as $catNeto){
                                        $pagina_array[$cont]['titulo'] = $espaco.$espaco.'--->'.$catNeto['titulo'];
                                        $pagina_array[$cont]['id'] = $item['id'].'-'.$catFilho['id'].'-'.$catNeto['id'];
                                        $pagina_array[$cont]['nome_tipo'] = $catNeto['nome_tipo'];
                                        $pagina_array[$cont]['status'] = $catNeto['status'];
                                        $pagina_array[$cont]['idPai'] =  $item['id'];
                                        $cont++;
                                      }                         
                                 }
                            }
                     }
                } 

				$i = 0;
                foreach ($pagina_array as $res){
					$i++;
                     //<td bgcolor="$css; " class="texto_contato">$x['nome_tipo']; </td>
					/*
                     echo "<tr><td bgcolor=\"$css\" class=\"texto_contato\" >".$res['titulo']."</td>
                         <td bgcolor=\"$css\" class=\"texto_contato\" >".$res['nome_tipo']."</td>
                          <td align=\"center\" class=\"texto_contato\">
                             <a href=\"index.php?pag=".$pagina."&tipo=e&id=".$res['id']."\">
                                <img src=\"img/editar.gif\" alt=\"Editar\" width=\"18\" height=\"20\" border=\"0\"></a>
                          </td>";
                      if ($res['status']==1){
                            echo"<td align=\"center\" class=\"texto_contato\">
                                            <a href=\"php/desativar.php?id=".$res['id']."&v=0&t=".$pagina."\">
                                            <img src=\"img/olho_visivel.gif\" alt=\"Ativar\" border=\"0\"></a>
                                    </td>";
                        }else{
                            echo"<td align=\"center\" class=\"texto_contato\">
                                        <a href=\"php/desativar.php?id=".$res['id']."&v=1&t=".$pagina."\">
                                        <img src=\"img/olho_oculto.gif\" alt=\"Ativar\" border=\"0\"></a>
                                </td>";
                        }
                            echo"<td align=\"center\" class=\"texto_contato\">
                                    <a href=\"javascript:confirmar('php/excluir.php?id=".$res['id']."&t=".$pagina."')\">
                                    <img src=\"img/excluir.gif\" alt=\"Excluir\" width=\"17\" height=\"18\" border=\"0\"> </a>
                              </td>
                              <td align=\"center\" class=\"texto_contato\">
                                    <a href=\"php/sobeP.php?id=".$res['id']."&t=".$pagina."\">
                                    <img src=\"img/sobe.gif\" alt=\"Sobe\" width=\"14\" height=\"20\" border=\"0\"></a>
                              </td>
                              <td align=\"center\" class=\"texto_contato\">
                                        <a href=\"php/desceP.php?id=".$res['id']."&t=".$pagina."\">
                                        <img src=\"img/desce.gif\" alt=\"Desce\" width=\"14\" height=\"20\" border=\"0\"></a>
                              </td>
                              </tr>";
              */

$idPag = substr($res['id'],-2);

echo "<div id=\"recordsArray_".$idPag."\" style='cursor:move;' title='Arraste para mover'>
<li>
	
	<div style=\"width:946px; height:25px; margin:2px 0; background:#F9F9F9; padding-top:5px;\">
	
	<div style=\"width:465px; height:25px; float:left; text-align:left; font-weight:normal;\">".$res['titulo']."</div>
	
	<div style=\"width:175px; height:25px; float:left; font-weight:normal;\">".$res['nome_tipo']."</div>
	
	<div style=\"width:102px; height:25px; float:left; \">
		<a href=\"index.php?pag=".$pagina."&tipo=e&id=".$res['id']."\">
			<img src=\"img/editar.gif\" alt=\"Editar\" width=\"18\" height=\"20\" border=\"0\">
		</a>
	</div>
";

if ($res['status']==1){
	echo "<div style=\"width:102px; height:25px; float:left\">
		<a href=\"php/desativar.php?id=".$res['id']."&v=0&t=".$pagina."\">
			<img src=\"img/olho_visivel.gif\" alt=\"Ativar\" border=\"0\">
		</a>
	</div>";
}else{
	echo "<div style=\"width:102px; height:25px; float:left\">
		<a href=\"php/desativar.php?id=".$res['id']."&v=1&t=".$pagina."\">
			<img src=\"img/olho_oculto.gif\" alt=\"Ativar\" border=\"0\">
		</a>
	</div>";
}

if ($res['nome_tipo'] == "Capa do Site") {
  echo "
    <div style=\"width:102px; height:25px; float:left\">
    </div>    
    </div>
  </li>
  </div>
  ";
} else {
  echo "
  	<div style=\"width:102px; height:25px; float:left\">
  		<a href=\"javascript:confirmar('php/excluir.php?id=".$res['id']."&t=".$pagina."')\">
  			<img src=\"img/excluir.gif\" alt=\"Excluir\" width=\"17\" height=\"18\" border=\"0\">
  		</a>
  	</div>
  	
  	</div>
  	
  </li>

  </div>
  ";
}


			  } 				
	  }  
          lista($paginas['pag_tab_id']);
?>


</ul>
			</div>

	</td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
  <div id="contentRight"></div>
</table>

