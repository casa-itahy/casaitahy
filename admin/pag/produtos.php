<?php 
include_once("php/sessao.php");
session_write_close();

if(isset($_POST['inputString'])){
	$buscar = $_POST['inputString'];
} else if(isset($_GET['buscar'])) {
	$buscar = $_GET['buscar'];
} else {
	$buscar = '';
}

$onde = '';

$categorias = query("SELECT titulo, id FROM categorias_subcat");

#----------------------------------------------------------#
if ($buscar){
    $sql = "SELECT p.id,p.titulo,p.cod,p.valor,p.status,p.destaque,p.categoria_id,p.lancamento FROM produtos p WHERE titulo LIKE '%$buscar%' ORDER BY categoria_id,posicao ";
}else{
	$sql = "SELECT p.id,p.titulo,p.cod,p.valor,p.status,p.destaque,p.categoria_id,p.lancamento FROM produtos p ORDER BY categoria_id,posicao";
}

	##### VERIFICA PAGINAÇÃO #######
	$registros_pagina = "150";
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

	if(isset($_GET['lista'])) {
		$getLista = $_GET['lista'];
	}else{
		$getLista = "";
	}
	
	if(isset($_GET['o'])) {
		$geto = $_GET['o'];
	}else{
		$geto = "";
	}
	
	if(isset($_GET['buscar'])) {
		$getBuscar = $_GET['buscar'];
	}else{
		$getBuscar = "";
	}

?>

<script language ="JavaScript">
function confirmar(query){
	if(window.confirm("Deseja realmente EXCLUIR este Produto \n e todas imagens cadastradas?")){
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
	width: 970px;
	margin:0;
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
			$.post("php/ordena_produtos.php", order, function(theResponse){
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


<div id="listarProdutos">
	<div id="listarPriLinha">
    	<div style="float:left">
            <a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a">
                <img src="img/incluir.png" alt="" border="0" style="float:left; margin-right:4px;" />
            </a>
            
            <div class="listarPriLinhaNome">
            	<a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=a">
                Incluir
                <?php echo $paginas['titulo']; session_write_close(); ?>
                </a>
            </div>
        </div>
        
        <div style="float:right; position:relative; display: none;">
        	<form action="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=p" method="post" id="buscaProdutos" name="formbusca" style="margin-top:15px;" autocomplete="off">
                <p style="color: #00267F; float: left; font-family:tahoma; font-size: 13px; font-weight: bold; margin: 3px 10px 0 0; padding: 0;">Pesquisar por titulo</p>
                <input type="text" name="inputString" id="inputString" onkeyup="lookup(this.value);" style="width:250px" />&nbsp;&nbsp;
                <a href="javascript:document.formbusca.submit();">
                	<img src="img/search_16.png" alt="Buscar" border="0">
                </a>
                
                <div class="suggestionsBox" id="suggestions" style="display: none;">
					<img src="img/upArrow.png" style="position: relative; top: -12px; left:-110px" alt="upArrow" />
					<div class="suggestionList" id="autoSuggestionsList">
						&nbsp;
					</div>
				</div>
            </form>
        </div>
    </div>
    <div style="clear: both;"></div>
    <?php if (!empty($_GET['msg'])): ?>
	    <h1><?php echo $_GET['msg']; ?></h1>
	    <div style="clear: both; height: 20px;"></div>
    <?php endif ?>
<!-- 	<form action="php/importar-produtos.php" method="post" enctype="multipart/form-data" class="titulo_noticias">
		<label for="produtos" style="width: 100px; display: inline-block; text-align: right;">Produtos:</label>
		<select name="categoria">
			<option value="">Selecione</option>
			<?php foreach ($categorias as $categ): ?>
				<option value="<?php echo $categ['id']; ?>"><?php echo $categ['titulo']; ?></option>
			<?php endforeach ?>
		</select>
		<input name="file_upload" type="file" required="required" id="produtos">
		<button class="botao_form" style="padding: 4px 15px;">Importar</button>
	</form> -->
    <div style="clear: both; height: 20px;"></div>
    
<div style="width:500px; height:25px; margin-left:auto; margin-right:auto; margin-bottom:5px;">
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

</div>

    
    
    <div id="listarProdutosTitulo">
    	<div id="listarProdutosTituloTexto" style="width:708px; text-align:left; padding-left:7px;">Produto</div>
        <!--<div id="listarProdutosTituloTexto" style="width:100px;">Código</div>
        <div id="listarProdutosTituloTexto" style="width:92px;">R$</div>-->
        <!-- <div id="listarProdutosTituloTexto" style="width:210px;">Categoria</div> -->
        <div id="listarProdutosTituloTexto" style="width:80px;">Editar</div>
        <!-- <div id="listarProdutosTituloTexto" style="width:80px;">Destaque</div> -->
        <div id="listarProdutosTituloTexto" style="width:80px;">Ocultar</div>
        <div id="listarProdutosTituloTexto" style="width:80px;">Excluir</div>
    </div>
    
    <div id="contentLeft">
		<ul>
    
	<?php foreach ($retorno as $x){
			if ($css == "#EFEFEF"){
				$css = "#FFFFFF";
			}else{
				$css = "#EFEFEF";
			}

			$idPro = $x['id'];
			// $categ = query("SELECT titulo FROM categorias_subcat WHERE id= ".$x['categoria_id']);
	
    ?>

    		<div id="recordsArray_<?php echo $idPro ?>" style="cursor:move;" title="Arraste para mover">
                <li>
                    <div id="listaProdutosLista">
                        <div id="listaProdutosListaNome" style="width:708px; text-align:left; padding-left:7px; background:<?php echo $css ?>"><?php echo $x['titulo'] ?></div>
                        <!--
                        <div id="listaProdutosListaNome" style="width:100px; background:<?php echo $css ?>"><?php echo $x['cod'] ?></div>
                        
                        <div id="listaProdutosListaNome" style="width:92px; background:<?php echo $css ?>">R$ <?php echo $x['valor']?></div>
                        -->
                        <!-- <div id="listaProdutosListaNome" style="width:210px; background:<?php echo $css ?>"><?php echo $categ[0]['titulo'] ?></div> -->
                        
                        <div id="listaProdutosListaNome" style="width:80px; background:<?php echo $css ?>">
                            <a href="index.php?pag=<?php echo $paginas['pag_tab_id'] ?>&tipo=e&id=<?php echo $x['id']?>&lista=<?php echo $getLista ?>&o=<?php echo $geto ?>&buscar=<?php echo $getBuscar ?>">
                                <img src="img/editar.gif" alt="Editar" width="18" height="20" border="0">
                            </a>
                        </div>

<!--                         <div id="listaProdutosListaNome" style="width:80px; background:<?php echo $css ?>">
                            <?php if ($x['destaque']==1){ ?>
                                <a href="php/destaque.php?id=<?php echo $x['id']?>&v=0&t=<?php echo $paginas['pag_tab_id'] ?>&lista=<?php echo $getLista ?>&o=<?php echo $geto ?>&buscar=<?php echo $getBuscar ?>">
                                    <img src="img/destaque.gif" alt="Destaque" border="0">
                                </a>
                            <?php }else{ ?>
                                <a href="php/destaque.php?id=<?php echo $x['id']?>&v=1&t=<?php echo $paginas['pag_tab_id'] ?>&lista=<?php echo $getLista ?>&o=<?php echo $geto ?>&buscar=<?php echo $getBuscar ?>">
                                    <img src="img/nao_destaque.gif" alt="Não é Destaque" border="0">
                                </a>
                            <?php } ?>
                        </div> -->

                        <div id="listaProdutosListaNome" style="width:80px; background:<?php echo $css ?>">
                            <?php if ($x['status']==1){ ?>
                                <a href="php/desativar.php?id=<?php echo $x['id']?>&v=0&t=<?php echo $paginas['pag_tab_id'] ?>&lista=<?php echo $getLista ?>&o=<?php echo $geto ?>&buscar=<?php echo $getBuscar ?>">
                                    <img src="img/olho_visivel.gif" alt="Ativar" border="0">
                                </a>
                            <?php }else{ ?>
                                <a href="php/desativar.php?id=<?php echo $x['id']?>&v=1&t=<?php echo $paginas['pag_tab_id'] ?>&lista=<?php echo $getLista ?>&o=<?php echo $geto ?>&buscar=<?php echo $getBuscar ?>">
                                    <img src="img/olho_oculto.gif" alt="Desativar" border="0">
                                </a>
                            <?php } ?>
                        </div>
                        <div id="listaProdutosListaNome" style="width:80px; background:<?php echo $css ?>">
                            <a href="javascript:confirmar('php/excluir.php?id=<?php echo $x['id']?>&t=<?php echo $paginas['pag_tab_id'] ?>&lista=<?php echo $getLista ?>&o=<?php echo $geto ?>&buscar=<?php echo $getBuscar ?>')">
                                <img src="img/excluir.gif" alt="Excluir" width="17" height="18" border="0">
                            </a>
                        </div>

                    </div>
                
                </li>
            
            </div>
    
    <?php } ?>
    
    	</ul>
    </div>
    
</div>
