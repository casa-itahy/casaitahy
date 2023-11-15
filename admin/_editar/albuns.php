<div id="statusAtualiza" style="width:300px; height:70px; background:#333; position:fixed; z-index:100; top:50px; right:50px; display:none">
	<div id="statusAtualizaDentro" style="margin-top:12px;"></div>
</div>
<?php
include("php/sessao.php");
        
session_write_close();
include_once("includes/functions.php");

$id = $_GET['id'];

$modulo = query("SELECT modulo_gemeo FROM modulos WHERE pag_tab_id='".$pag."';");       

$idiomas = query("SELECT * FROM idiomas WHERE  status=1 AND sigla!='Port'");

$sql = "(SELECT ai.titulo,ai.conteudo,i.nome, i.sigla 
         FROM albuns_idioma ai  
            LEFT JOIN idiomas i ON(ai.idioma_id=i.id)
        WHERE ai.albuns_id=$id AND i.status=1 ORDER BY i.id)
        UNION ALL
        (SELECT null,null,i.nome, i.sigla
            FROM idiomas i
            WHERE i.status=1 
			   AND i.id!=1
               AND id NOT IN (SELECT idioma_id FROM albuns_idioma WHERE albuns_id=$id)
            ORDER BY i.id)";

$albuns_idioma = query($sql);

$sql = "SELECT * FROM albuns WHERE id=$id ";
$dados = query($sql);

$sql = "SELECT * FROM albuns_clientes WHERE albuns_id=$id ";
$albuns_clientes = query($sql);
 
$clientes = query("SELECT id, nome FROM clientes WHERE status = 1 ORDER BY nome");

$sql = "SELECT * FROM img_pasta_albuns WHERE albuns_id=$id ORDER BY posicao";
$imagens = query($sql);

$sql = "SELECT DISTINCT(pasta) FROM img_pasta_albuns WHERE albuns_id=$id ORDER BY posicao";
$pastasImagens = query($sql);

$sqlRec = "SELECT * FROM recados WHERE id_album = '$id' ORDER BY id DESC ";
$retornoRec = query($sqlRec);

$atributos_itens = getAtributosItens(3); //3 albuns

$titulo = htmlspecialchars ($dados[0]['titulo']);

$categorias = query("SELECT * FROM categorias_noticias ORDER BY titulo ASC");

if (!empty($imagens[0]['pasta'])){
    $pics = array();
        foreach($pastasImagens as $pasta){
            $pasta = "imagens/".$pasta['pasta'];
            if (is_dir($pasta)){
                $dir = opendir($pasta);
                if (!empty($dir)){                    
                        $exp="/jpg|jpeg|JPG|JPEG|bmp|png|gif/";
                    while ($fname = readdir($dir)){
                        if (preg_match($exp,$fname)){
                            $pics[$fname]=$fname;
                        }
                    }
                closedir($dir);
                }
                $tam = count($pics);
            }
        }
}

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

$sql = "SELECT * FROM links WHERE tipo = 5 AND lin_id_pg = $id";
$links = query($sql);

?>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <style type="text/css">
        #gallery {width:100%; list-style-type:none; margin:0px; padding:0px; }
        #gallery li {display: inline-block; width:180px; max-height:180px; margin:3px;}
        #gallery div { max-width:180px; max-height:180px;  border:none; text-align:center; }
        .placeHolder div { background-color:white !important; border:dashed 1px gray !important; }
    </style>    
    
<!-- Mudar a data -->
<link rel="stylesheet" type="text/css" href="css/jquery.ui.all.css"/>
<link rel="stylesheet" type="text/css" href="css/jquery.ui.datepicker.css"/>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker.js"></script>

<script type="text/javascript">
    jQuery(function($){
        $("#datepicker").datepicker({  
            dateFormat: 'dd/mm/yy',
            monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'] ,
            dayNamesMin: ['D','S', 'T', 'Q', 'Q', 'S', 'S'],
            nextText: '>',
            prevText: '<'
        }); 
    });
</script>
<!-- Mudar a data -->

    <form action="_update/albuns.php" enctype="multipart/form-data" method="post" id="form" >
        <input name="list1SortOrder" type="hidden" />
        <input type="hidden" id="tabela" name="tabela" value="albuns" />
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>&lista=<?php echo $getLista ?>&o=<?php echo $geto ?>&buscar=<?php echo $getBuscar ?>" />        
<table border="0" align="center" cellpadding="2" cellspacing="2" style="width:900px;">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><h1>Editar
    <?php        
            echo $paginas['titulo'];            
     ?>
    </h1></td>
  </tr>
  
  
  <tr>      
      <td colspan="2" class="titulo_noticias">
          <div style="background-color:#C5CEFA; width: 100%; text-align: center;">T&iacute;tulo</div>
          <table>              
              <tr>                  
                  <?php echo '<td class="titulo_noticias" style="font-weight: normal; ">Português</td>
                            <td class="titulo_noticias"><label>
                                <input name="tituloPort" type="text" id="tituloPort" size="55"  class="required" value="'.$titulo.'" />
                            </label></td>';
                        if (count($albuns_idioma)>0) {
                            $total_criado=1;
                            foreach($albuns_idioma as $idioma){                                
                                $nome = $idioma['nome'];
                                $sigla=$idioma['sigla'];
                                $titulo=$idioma['titulo'];

                                if($total_criado==2){
                                    echo '</tr><tr>';
                                    $total_criado=0;
                                }
                                
                                echo '<td class="titulo_noticias" style="font-weight: normal;">'.$nome.'</td>
                                <td class="titulo_noticias"><label>
                                    <input name="titulo'.$sigla.'" type="text" id="titulo'.$sigla.'" size="55"  class="required" value="'.$titulo.'" />
                                </label></td>';
                                $total_criado++;
                            }
                        } else {
                            echo monta_input($idiomas, 'titulo');
                        }
                  ?>
              </tr>
          </table> 
          <br />
      </td>    
  </tr>

    <tr>
        <td colspan="2" class="titulo_noticias">
            <br />
            <table>              
                <tr>
                    <td class="titulo_noticias" width="125" style="font-weight: normal;">Data</td>
                    <td class="titulo_noticias">
                        <input type="text" class='required' id="datepicker" size="10" name="created" value="<?php echo date('d/m/Y', strtotime($dados[0]['created'])); ?>" />
                    </td>
                </tr>
            </table>
        </td>
        </td>
    </tr>

    <tr>
        <td colspan="2" class="titulo_noticias">
            <table>
                <tr>
                    <td class="titulo_noticias" width="125" style="font-weight: normal;">Categoria</td>
                    <td class="titulo_noticias">
                        <select name="categoria" id="categoria">
                            <option value="">Selecione</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option <?php if ($cat['id'] == $dados[0]['tipo']): ?> selected="selected" <?php endif ?> value="<?php echo $cat['id']; ?>"><?php echo $cat['titulo']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
            </table>
        </td>
        </td>
    </tr>

    <tr>
	    <td colspan="2" class="titulo_noticias" align="center">
        	<div style="background:#00579E; width:auto; height:auto; padding:10px 0; margin:20px 0; color:#FFF; line-height:30px;">
                Dicas para um bom posicionamento do seu site nos sites de busca: <a href="http://artwebdigital.com.br/wiki/dicas-seo/dicas-seo.pdf" style="background:#FFF; width:200px; height:30px; text-align:center; line-height:30px; display:block; margin-top:10px;" target="_blank">Dicas de Otimização</a>
			</div>
        </td>
    </tr>

    <tr>
        <td colspan="2" class="titulo_noticias">
            <br />
            <table>              
                <tr>
                    <td class="titulo_noticias" width="125" style="font-weight: normal;">Title</td>
                    <td class="titulo_noticias">
                        <label>
                            <textarea name="title" id="title" cols="50" rows="3"><?php echo $links[0]['title']; ?></textarea>
                        </label>
                    </td>
                </tr>
            </table>
        </td>
    </tr>  

    <tr>
        <td colspan="2" class="titulo_noticias">
            <table>              
                <tr>
                    <td class="titulo_noticias" width="125" style="font-weight: normal;">Description</td>
                    <td class="titulo_noticias">
                        <label>
                            <textarea name="metad" id="metad" cols="50" rows="3"><?php echo $links[0]['metad']; ?></textarea>
                        </label>
                    </td>
                </tr>
            </table>
        </td>
    </tr>  
  
  <?php 
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'imagem_principal');
        if($ok!=false){
  ?>
  <tr <?php if ($pag == 38): echo "style='display: none'"; endif; ?>>
    <td class="titulo_noticias">
        <div class="titulo_noticias" style='float:left;'>
        	<?php echo $ok; ?>
        	&nbsp;
        </div>
    <?php
	$imagem = $dados['0']['imagem'];
	$caminho = "imagens/albuns/thumb_".$imagem;
        if($imagem!="") { ?>
                <img style="max-width: 200px;" src="<?php echo $caminho; ?>">
                	<a href="php/apagarImagem.php?pasta=albuns&id=<?php echo $id; ?>&pag=<?php echo $paginas['pag_tab_id']; ?>">
                		&nbsp;Apagar
                	</a>
	<?php }else{ ?>
            <input name="imagem" type="file" id="imagem" size="43" />
   <?php } ?>   
   <!-- <br />A imagem deve ter exatamente 880 pixels de largura por 580 pixels de altura. -->
   </td>
  </tr>
    <tr style="display: none;">
        <td colspan="2" class="titulo_noticias">
            <table>              
                <tr>
                    <td class="titulo_noticias" width="125">Vídeos<br /><span style="font-weight: normal;">Coloque uma URL por linha.</span></td>
                    <td class="titulo_noticias">
                        <label>
                            <textarea name="videos" id="videos" cols="60" rows="3"><?php echo $dados[0]['videos']; ?></textarea>
                        </label>
                    </td>
                </tr>
            </table>
        </td>
    </tr>  
  <?php /*
	PARA VOLTAR A FUNCIONAR DESCOMENTE A LINHA A CIMA!
  
	<tr>
		<td class="titulo_noticias">
		
			<div style="background-color:#C5CEFA; text-align: center;">Clientes</div>
			
			<select multiple name="acessoClientes[]" style="height: 250px; min-width: 350px;">
			  <?php
					foreach ($clientes as $c) {
						$achou = false;
						foreach ($albuns_clientes as $ac) {
							if ($ac['clientes_id'] == $c['id']) {
								echo "<option value='".$c['id']."' selected='selected' >".$c['nome']."</option>";
								$achou = true;
							}
						}
						if(!$achou){
							echo "<option value='".$c['id']."' >".$c['nome']."</option>";
						}
					}
			   ?>
			</select>

			<span class="valor_prod">
				Aperte e segure a tecla "Ctrl" para selecionar vários clientes.
			</span>

		</td>
	</tr>
  
  	*/?>
  <?php 
        }
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'conteudo');
        if($ok!=false){
  ?>
        
  <tr <?php if ($pag == 38): echo "style='display: none'"; endif; ?>>
      <td colspan="2" class="titulo_noticias">
          <input type="hidden" id="altura_albuns"  name="altura_albuns" value="0" />
          <input type="hidden" id="largura_albuns" name="largura_albuns" value="0" />
          <div style="background-color:#C5CEFA; text-align: center;"><?php echo $ok; ?></div>
          <table>            
              <?php 
                    echo '<tr><td class="titulo_noticias" style="font-weight: normal;">Português</td>
                              <td class="titulo_noticias">
                                     <textarea name="textoPort" id="textoPort" cols="92" rows="3">'.$dados[0]['conteudo'].'</textarea>
                                </td></tr>';
              
                    if(count($albuns_idioma)>0){    
                        foreach($albuns_idioma as $idioma){
                            echo '<tr><td class="titulo_noticias" style="font-weight: normal;">'.$idioma['nome'].'</td>
                                  <td class="titulo_noticias">
                                         <textarea name="texto'.$idioma['sigla'].'" id="texto'.$idioma['sigla'].'" cols="92" rows="3">'.$idioma['conteudo'].'</textarea>
                                    </td></tr>';  
                        }
                    }else{
                        foreach($idiomas as $idioma){
                            echo '<tr><td class="titulo_noticias" style="font-weight: normal;">'.$idioma['nome'].'</td>
                                  <td class="titulo_noticias">                                     
                                         <textarea name="texto'.$idioma['sigla'].'" id="texto'.$idioma['sigla'].'" cols="92" rows="3"></textarea>
                                    </td></tr>';
                        }
                    }                            
              ?>
          </table> 
        </td>
  </tr> 
<?php } ?>
   <tr>
    <td colspan="2" align="center" class="titulo_noticias">
        <input type="submit" value="Gravar" class="botao_form" />
    </td>
 </tr>
  <tr>
    <td colspan="2" align="center" class="titulo_noticias">&nbsp;
      
    </td>
 </tr>  
  <?php 
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'imagens');
        if($ok!=false){
  ?>
  <tr>
    <td colspan="2" class="titulo_noticias">
        <div style="background-color:#C5CEFA; width: 100%; text-align: center;"><?php echo $ok; ?></div>
    </td>
  </tr>
  
  <tr>
    <td colspan="2" class="titulo_noticias">
        
    <!--   CRIAÇÃO DE ALBUNS FLUTUANTE DRAG DROP -->
    <div>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <ul id="gallery">
        <?php	                
               $html='';
               if(empty($imagens[0]['pasta'])){
                    $msg = "Nenhuma imagem!";
                    $html .= "<span class='msg'>".$msg."</span>";
               }else{
                   foreach($imagens as $i => $img){        
                        $src=$img['src'];               
                        $html.= "<li itemID='".$img['id']."'>
                                    <div>  
                                        <img src='imagens/".$img['pasta']."/thumb_".$pics[$src]."' style='max-width:180px; max-height:120px;' />      
                                    </div>
                                    <center style='background-color:#ECE9E2;'>";
                                            /* $html.="<a href=javascript:editar(".$img['id'].")>
                                                    <img src='./img/edit_16x16.gif' alt='Editar' title='Editar' width='13' height='13' border='0'>
                                                </a>&nbsp;&nbsp;&nbsp;&nbsp;"; */
                                                if($img['status']==1){
                                                    $html.= "<a href=javascript:ocultar(".$img['id'].",v=0)> <img id='imgoculto".$img['id']."' src='./img/olho_visivel.gif' alt='Ocultar' title='Ocultar' width='20' height='13' border='0'>";
                                                }else{
                                                    $html.= "<a href=javascript:ocultar(".$img['id'].",v=1)> <img id='imgoculto".$img['id']."' src='./img/olho_oculto.gif' alt='Ativar' title='Ativar' width='20' height='13' border='0'>";
                                                }
                                                //<a href=javascript:confirmar(".$img['id'].")>
                                            $html.= "</a>&nbsp;&nbsp;&nbsp;&nbsp;                                                
                                                <a href=javascript:confirmar('php/apagarImagemAlbum.php?id=".$id."&pasta=".$img['pasta']."&img=".$pics[$src]."&imgid=".$img['id']."&pag=".$paginas['pag_tab_id']."') >
                                                        <img src='./img/excluir.gif' alt='Excluir' title='Excluir' width='13' height='13' border='0'>
                                                </a>
												<div style='width:100%; height: 37px; background:#CCC; margin:0 0 10px 0;'>
													<textarea style='width:97%; height:38px; font-size:13px; color:#999;' name='desc' id='desc_".$i."' onBlur=\"atualizaDesc(this.value, ".$img['id'].")\" >".$img['legenda']."</textarea>
												</div>
                                    </center>
									
									
                                    
                                </li>";
                        }
               }
               echo $html;	
               ?>
		</ul>
		
		<script type="text/javascript" src="js/jquery.dragsort-0.4.2.min.js"></script>
		<script type="text/javascript">
		    $("#gallery").dragsort({ dragSelector: "div", dragEnd: saveOrder, placeHolderTemplate: "<li class='placeHolder'><div></div></li>" });

		    function saveOrder() {
				var data = $("#gallery li").map(function() { return $(this).attr("itemID"); }).get();
		        $.post("php/ordena_img_album.php", { "ids[]": data });                        
		    };
			
			function atualizaDesc(nText, idImgm) {
			
			$('#statusAtualiza').show();
			$("#statusAtualizaDentro").html("<center><img src='img/ajaxLoa.gif'/></center>");
				$.post('_update/descImg.php', {nText: nText, idImgm:idImgm }, function(resposta) {
                                // Quando terminada a requisição
                                // Exibe a div status
                                $("#statusAtualizaDentro").slideDown();
                                // Se a resposta é um erro
                                if (resposta != false) {
                                        // Exibe o erro na div
                                        $("#statusAtualizaDentro").html(resposta);
                                } 
                                // Se resposta for false, ou seja, não ocorreu nenhum erro
                                else {
                                        // Limpando todos os campos
                                        $("#nome").val("");
                                        $("#email").val("");
                                        $("#telefone").val("");
                                        $("#mensagem").val("");
                                }
                });
				
			}
                    
                    function editar(id){
                    var url = '_editar/banners.php';
                    var pars = 'id=' + id +'&dummy= ' + new Date().getTime();
                    var myAjax = new Ajax.Request(                        
                        url,{
                                method: 'post',
                                parameters: pars,
                                onSuccess: retorno
                        });
               }
              
               function retorno(resposta){
                        displayWindow();
                        var resp = resposta.responseText;
                        document.getElementById('div_conteudo').innerHTML = resposta.responseText;
               }
               
               function ocultar(id,v){
                    var url = 'php/ocultar.php';
                    var pars = 'id=' + id + '&img_albuns=true'+'&dummy= ' + new Date().getTime();
                    var myAjax = new Ajax.Request(                        
                        url,{
                                method: 'post',
                                parameters: pars,
                                onSuccess: mudaImgOculto
                        });
               }
               
               function mudaImgOculto(resposta){
                    var resp = resposta.responseText;                    
                    var imagem=document.getElementById("imgoculto"+resp);
                    var caminho=imagem.src;
                    if(caminho.indexOf("olho_oculto")==-1){                        
                        imagem.src="./img/olho_oculto.gif";
                    }else{
                        imagem.src="./img/olho_visivel.gif";
                    }
               }
               
               function confirmar(query){
                if(window.confirm("Deseja realmente excluir essa imagem?")){
                           window.location= query;
                           return true;
                        }
                }
                /* ##### CAMPO LEGENDA DE CADA IMAGEM #### */
                function s_legenda(id){
                    if (id > 0){
                        var valor = document.getElementById('legenda'+id);
                        if(valor.value){
                            var url = 'php/img_legenda.php';
                            var pars = 'id='+id+'&valor='+valor.value;
                            var myAjax = new Ajax.Request(
                                url,{
                                    method: 'post',
                                    parameters: pars,
                                    onComplete: okLegenda
                                });
                        }
                    }
                }

                function limpar(id){
                     var txt = document.getElementById('legenda'+id);
                        if(txt.value){
                            if(txt.value=='Adicionar legenda'){
                                txt.value='';
                                txt.setAttribute("style", "color:#858585;");
                                txt.setAttribute("style", "font-size:9px;");
                            }            
                        }    
                }
                /* ############# FIM ######################## */
                function okLegenda(resposta){
                    //document.getElementById('div_cidade').innerHTML = resposta.responseText.toString();
                }
	    </script>        
        <div style="clear:both;"></div> 
    </div>
<!-- FIM MONTA DRAG DROP -->
</td>
 </tr>
 <tr>
 	<td align="center">
 		<input type="button" value="Atualizar Imagens" class="botao_form" onClick="window.parent.location.href = window.parent.location.href" />
 	</td>
 </tr>
<?php 
   }
?>
 <tr>
    <td colspan="2" class="titulo_noticias">
        <input type="hidden" id="pasta" name="pasta" value="<?php echo $dados[0]['pasta']; ?>" />
    </td>
 </tr>
  <tr>
    <td colspan="2" class="titulo_noticias">
   <?php         
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'imagens');
        if($ok!=false){
  ?>    
	<iframe src="./js/multiupload/album_admin.php?id=<?php echo $id; ?>&pag=<?php echo $pag;?>" width="100%" height="400" frameborder="0" allowtransparency="true" style="border: none; margin:0px; padding:0px;">
		<p>
			Seu navegador não suporta IFrames. <br/>
			Você poderá atualiza-lo ou instalar uma versão mais recente no site do proprietário. <br/>
			http://www.firefox.com <br/> 
			http://www.google.com/chrome
		</p>
	</iframe>
    <?php } ?>
    </td>
    </tr>
  <!-- COMENTÁRIOS -->
    <?php       
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'comentarios');
        if($ok!=false){
  ?>
    <tr>    
    <td colspan="2" class="titulo_noticias">
      <div style="background-color:#C5CEFA; width: 100%; text-align: center;"><?php echo $ok; ?></div>
        <table width="100%" border="0" cellspacing="2" cellpadding="3">
          <tr>
            <td width="400" height="28"   bgcolor="#004882" class="texto_rodape">T&iacute;tulo</td>
            <td width="50" align="center" bgcolor="#004882" class="texto_rodape">Vis&iacute;vel</td>
            <td width="50" align="center" bgcolor="#004882" class="texto_rodape">Excluir</td>
            <td width="100" align="center" bgcolor="#004882" class="texto_rodape">Data</td>
        </tr>  
      <?php foreach ($retornoRec as $x){
		   if ($css == "#EFEFEF")
			  {
				$css = "#FFFFFF";
			  }
			  else
			  {
				$css = "#EFEFEF";
			  }
	  ?>
      <tr>
        <td bgcolor="<?php echo $css; ?>" class="texto_contato"><?php echo $x['titulo']." &bull; <b>".$x['autor']."</b>"?> </td>
        <?php if ($x['status']==1){ ?>
        	<td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="php/desativar.php?id=<?php echo $x['id']?>&amp;v=0&amp;t=51&idEdit=<?php echo $id?>"><img src="img/olho_visivel.gif" alt="Ativar" border="0"></a></td>
        <?php } else { ?>
       	  <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="php/desativar.php?id=<?php echo $x['id']?>&amp;v=1&amp;t=51&idEdit=<?php echo $id?>"><img src="img/olho_oculto.gif" alt="Ativar" border="0"></a></td>
        <?php } ?>
        <td align="center"bgcolor="<?php echo $css; ?>" class="texto_contato">
        <a href="javascript:confirmar('php/excluir.php?id=<?php echo $x['id']?>&t=4&tipo=Noti&idEdit=<?php echo $id?>')"><img src="img/excluir.gif" alt="Excluir" width="17" height="18" border="0"></a></td>
        <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato">        
		<?php 
            echo $data = $x['data'];
		?>        </td>
        </tr>
      <?php }?>
    </table>               
    </td>
  </tr> 
  <?php } ?>
</table>
</form>
    

  <?php
        
        
function monta_textarea($idiomas,$nome){
    $text_html='';
    foreach($idiomas as $item){
        $text_html.= '<td class="titulo_noticias" style="font-weight: normal;">'.$item['nome'].'</td>
            <td class="titulo_noticias">
                <textarea name="'.$nome.$item['sigla'].'" id="'.$nome.$item['sigla'].'" cols="38" rows="3"></textarea>
            </td>';
    }
    return $text_html;
}
function monta_input($idiomas,$nome){
    foreach($idiomas as $item){
        echo '<td class="titulo_noticias" style="font-weight: normal;">'.$item['nome'].'</td>
        <td class="titulo_noticias"><label>
            <input name="'.$nome.$item['sigla'].'" type="text" id="'.$nome.$item['sigla'].'" size="55" />
        </label></td>';
    }
}
?>