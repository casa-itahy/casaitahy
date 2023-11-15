<?php 

  error_reporting(0);

include_once("sessao.php");
include_once('../includes/db.php');

$action 				= $_POST['action']; 
$updateRecordsArray 	= $_POST['recordsArray'];

if ($action == "updateRecordsListings"){
	
	$listingCounter = 1;

	foreach ($updateRecordsArray as $recordIDValue) {
		
		$conn = conecta();
		$query = "UPDATE paginas SET posicao = ".$listingCounter." WHERE id = ".$recordIDValue;
		//mysql_query($query) or die('Error, insert query failed');
		mysqli_query($conn, $query);
		$listingCounter = $listingCounter + 1;	
	}
	/*
	echo '<pre>';
	print_r($updateRecordsArray);
	echo '</pre>';
	*/
}


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
<script type="text/javascript" src="../js/drag/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../js/drag/jquery-ui-1.7.1.custom.min.js"></script>

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

$idPag = substr($res['id'],-2);
			  
echo "
<div id=\"recordsArray_".$idPag."\" style=\"cursor:move;\" title=\"Arraste para mover\">

<li>
	
	<div style=\"width:945px; height:25px; margin:2px 0; background:#F9F9F9; padding-top:5px;\">
	
	<div style=\"width:467px; height:25px; float:left; text-align:left; font-weight:normal;\">".$res['titulo']."</div>
	
	<div style=\"width:171px; height:25px; float:left; font-weight:normal;\">".$res['nome_tipo']."</div>
	
	<div style=\"width:103px; height:25px; float:left; \">
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
          lista($paginas['pag_tab_id']);
?>


</ul>
			</div>