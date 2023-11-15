<?php 
include("php/sessao.php");
session_write_close();

include_once("includes/functions.php");

$id = $_GET['id'];

$sql = "SELECT * FROM idiomas WHERE status=1 AND sigla!='Port'";
$idiomas = query($sql);

/*$sql = "SELECT pi.*,i.nome, i.sigla FROM produtos_idioma pi
            LEFT JOIN idiomas i ON(pi.idioma_id=i.id)    
        WHERE pi.produto_id=$id ORDER BY i.id";*/

$sql = "(SELECT i.nome, i.sigla,pi.titulo,pi.descricao,pi.title,pi.metad,pi.conteudo
         FROM produtos_idioma pi
            LEFT JOIN idiomas i ON(pi.idioma_id=i.id)    
        WHERE i.status=1 AND pi.produto_id=$id ORDER BY i.id)
        UNION ALL
        (SELECT i.nome, i.sigla,null,null,null,null,null
            FROM idiomas i
            WHERE i.status=1 AND i.id!=1
               AND id NOT IN (SELECT idioma_id FROM produtos_idioma WHERE produto_id=$id)
            ORDER BY i.id)";


$dados_idioma = query($sql);



$sql = "SELECT * FROM produtos	WHERE id=$id ";
$dados = query($sql);

$titulo = htmlspecialchars ($dados[0]['titulo']);
$cod = htmlspecialchars ($dados[0]['cod']);
$endereco = htmlspecialchars ($dados[0]['endereco']);

$sql = "SELECT id,titulo FROM categorias_subcat ORDER BY titulo";
$retorno = query($sql);

$sql = "SELECT * FROM img_pasta_prod WHERE produto_id=$id ORDER BY posicao";
$imagens = query($sql);

$sql = "SELECT DISTINCT(pasta) FROM img_pasta_prod WHERE produto_id=$id ORDER BY posicao";
$pastasImagens = query($sql);

$tipoConteudo = query("SELECT exibicao FROM categorias_subcat WHERE id = ".$dados[0]['categoria_id']);

$atributos_itens = getAtributosItens(7);

//voltar sem perder filtros ....
	if(isset($_GET['lista'])) {
		$getLista = $_GET['lista'];
	}
	
	if(isset($_GET['o'])) {
		$geto = $_GET['o'];
	}
	
	if(isset($_GET['buscar'])) {
		$getBuscar = $_GET['buscar'];
	}
?>

<script type="text/javascript" src="js/modulos_js/formataReais.js"></script>
    <script type="text/javascript" src="js/validation.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <style type="text/css">
        #gallery {width:100%; list-style-type:none; margin:0px; padding:0px; }
        #gallery li {display: inline-block; width:180px; max-height:180px; margin:3px;}
        #gallery div { max-width:180px; max-height:180px;  border:none; text-align:center; }
        .placeHolder div { background-color:white !important; border:dashed 1px gray !important; }
    </style>
    
<form action="_update/produtos.php" enctype="multipart/form-data" method="post" id="form" >
<input type="hidden" id="tabela" name="tabela" value="produtos" >
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" >
<input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>&lista=<?php echo $getLista ?>&o=<?php echo $geto ?>&buscar=<?php echo $getBuscar ?>" >
<input type="hidden" id="get" name="get" value="&lista=<?php echo $getLista ?>&o=<?php echo $geto ?>&buscar=<?php echo $getBuscar ?>" >
<input type="file" name="fileupload" id="fileupload" style="display: none;" />
<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><h1>Editar
   	<?php            
            echo $paginas['titulo'];
            session_write_close();
	?>
    </h1></td>
  </tr>
  
  <tr>
    <td height="15" colspan="2" align="center"></td>
  </tr>
  <?php 
    //########### VERIFICA O STATUS DO ATRIBUTO ###################
    $ok = getStatusAtributo($atributos_itens,'titulo');
    if($ok!=false){
  ?>
    <tr>
      <td class="titulo_noticias">
        <div style="float:left; width: 125px;"><?php echo $ok; ?></div>
      <?php echo '<input name="tituloPort" type="text" id="tituloPort" size="55"  class="required" value="'.$titulo.'" />'; ?>
      </td>
    </tr>
  <?php
  $ok = getStatusAtributo($atributos_itens, 'valor');
  if($ok != false){
  ?>
    <tr>
      <td class="titulo_noticias">
        <div style="float:left; width: 125px;">Código</div>
        <input name="cod" type="text" size="50" value="<?php echo $cod ?>" />
      </td>
    </tr>
    <tr>
      <td class="titulo_noticias">
        <div style="float:left; width: 125px;">Metragem</div>
        <input name="metragem" type="text" size="20" value="<?php echo $dados[0]['metragem'] ?>" />
        Preencher somente números. Ex: <span style="font-weight: normal;">96</span>
      </td>
    </tr>
    <tr>
      <td class="titulo_noticias">
        <div style="float:left; width: 125px;">Dormitórios</div>
        <input name="dormitorios" type="text" size="20" value="<?php echo $dados[0]['dormitorios'] ?>" />
        Preencher somente números. Ex: <span style="font-weight: normal;">3</span>
      </td>
    </tr>
    <tr>
      <td class="titulo_noticias">
        <div style="float:left; width: 125px;">Suítes</div>
        <input name="suites" type="text" size="20" value="<?php echo $dados[0]['suites'] ?>" />
        Preencher somente números. Ex: <span style="font-weight: normal;">3</span>
      </td>
    </tr>
    <tr>
      <td class="titulo_noticias">
        <div style="float:left; width: 125px;">Vagas</div>
        <input name="vagas" type="text" size="20" value="<?php echo $dados[0]['vagas'] ?>" />
        Preencher somente números. Ex: <span style="font-weight: normal;">3</span>
      </td>
    </tr>
    <tr>    
        <td class="titulo_noticias"><div style="float:left; width: 125px;"><?php echo $ok; ?></div><input name="valor" type="text" id="valor" size="20" value="<?php echo $dados[0]['valor'] ?>" length="15" onkeypress="reais(this,event)" onkeydown="backspace(this,event)" /></td>
    </tr>
    <tr>
      <td class="titulo_noticias"><div style="float:left; width: 125px;">Valor Condomínio</div>
        <input name="condominio" type="text" size="55" value="<?php echo $dados[0]['condominio'] ?>" />
        Preencher a informação completa. Ex: <span style="font-weight: normal;">R$ 830/mês</span>
      </td>
    </tr>
    <tr>
      <td class="titulo_noticias"><div style="float:left; width: 125px;">Valor IPTU</div>
        <input name="iptu" type="text" size="55" value="<?php echo $dados[0]['iptu'] ?>" />
        Preencher a informação completa. Ex: <span style="font-weight: normal;">R$ 240/mês</span>
      </td>
    </tr>
    <tr>
      <td class="titulo_noticias"><div style="float:left; width: 125px;">Código Mapa</div>
        <input name="endereco" type="text" size="55" value="<?php echo $endereco; ?>" />
        (Código incorporado do Google Maps)
      </td>
    </tr>
  <?php } ?>
      <tr style="display: none;">
          <td class="titulo_noticias">
              <div style="float:left; width: 125px;">Texto Topo Formulário</div>
              <input name="textoBotao" type="text" id="textoBotao" size="51" value="<?php echo $dados[0]['textoBotao']; ?>" />
          </td>
      </tr>
   <?php 
        }
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'categoria');
        if($ok!=false){
  ?>
  <tr>
    <td class="titulo_noticias">
        <div style="float:left; width: 125px;"><?php echo $ok; ?></div>    
        </label><input type="hidden" id="pasta" name="pasta" value="<?php echo $imagens[0]['pasta']; ?>" />
    <select name="categoria" id="categoria" class="validate-selection">
        <option>-- Escolha --</option>
            <?php
                  /*#############################################
		  * ##### BUCA TODAS AS CATEGORIAS PAI ########
                   ####################################*/
                $sql = "SELECT cs.id,cs.titulo,cs.status,cs.posicao
                        FROM categorias_subcat cs
                        RIGHT JOIN cat_subcat_nivel csn ON (cs.id = csn.cat_pai_id)
                        WHERE csn.cat_filho_id IS NULL
                        AND csn.cat_neto_id IS NULL
                        AND csn.sub_cat_id IS NULL
                        ORDER BY cs.posicao";
                $categorias = query($sql);
                
                $selected='';
		foreach ($categorias  as $r){
                        
                        if($r['id']==$dados[0]['categoria_id'])
                            $selected='selected';

			echo "<option value=".$r['id']." $selected>".$r['titulo']."</option>";
                        $selected='';
                        //BUSCA FILHOS
			$sql ="SELECT c.id, csn.cat_filho_id, c.titulo, c.status
                                   FROM categorias_subcat c
                                   LEFT JOIN cat_subcat_nivel csn ON (c.id=csn.cat_filho_id)
                                   WHERE csn.cat_pai_id='".$r['id']."'
                                   AND csn.cat_neto_id IS NULL
                                   ORDER BY c.posicao ASC";
                        $catFilho_array=query($sql);
                        
			foreach ($catFilho_array as $f){
                            if($f[id]==$dados[0]['categoria_id'] && $selected=='')
                                    $selected='selected';

                            echo "<option value=".$f['id']." $selected >-- ".$f['titulo']."</option>";
                            $selected='';
                                                            
                                /*##############################################
                                 *####### BUCA TODAS AS CATEGORIAS NETO ########
                                 ################################################*/
                                 $sql=("SELECT c.id, csn.cat_filho_id, c.titulo, c.status
                                                           FROM categorias_subcat c
                                                           LEFT JOIN cat_subcat_nivel csn ON (c.id=csn.cat_neto_id)
                                                           WHERE csn.cat_filho_id='".$f['cat_filho_id']."'
                                                           ORDER BY c.posicao ASC");

                                 $catNeto_array = query($sql);
                                 if(count($catNeto_array)>0){
                                     foreach ($catNeto_array as $catNeto){
                                        if($catNeto['id']==$dados[0]['categoria_id'] && $selected=='')
                                        $selected='selected';
                                         
                                        echo "<option value=".$catNeto['id']." $selected >---- ".$catNeto['titulo'] . "</option>";
                                        $selected='';
                                     }
                                 }
                            
                            
			}
		}
	  ?>
    </select></td>    
  </tr>
      <tr <?php if ($tipoConteudo[0]['exibicao'] != 2): echo "style='display: none;'"; endif ?>>
          <td class="titulo_noticias">
              <div style="float:left; width: 125px;">Link do Botão</div>
              <input name="linkBotao" type="text" id="linkBotao" size="51" value="<?php echo $dados[0]['linkBotao']; ?>" />
          </td>
      </tr>
      <tr <?php if ($tipoConteudo[0]['exibicao'] != 2): echo "style='display: none;'"; endif ?>>
          <td class="titulo_noticias">
              <div style="float:left; width: 125px;">Abrir Link</div>
              <input type="radio" <?php if ($dados[0]['target'] == 1): ?>checked="checked"<?php endif ?> checked="checked" name="target" value="1" /> Mesma Janela
              <input type="radio" <?php if ($dados[0]['target'] == 2): ?>checked="checked"<?php endif ?> name="target" value="2" /> Nova Janela
          </td>
      </tr>
            <tr>
                <td class="titulo_noticias">&nbsp;</td>
            </tr>

   <?php 
        }
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'imagem');
        if($ok!=false){
  ?>
  <tr>
    <td class="titulo_noticias">    	
                <div style="float:left; width: 125px;"><?php echo $ok; ?></div>    
        
    <?php
	$imagem = $dados[0]['imagem'];
	$caminho = "imagens/produtos/thumb_".$imagem;
	 if($imagem!=""){
     ?>
            <img src="<?php echo $caminho; ?>"><a href="php/apagarImagem.php?pasta=produtos&id=<?php echo $id; ?>&pag=<?php echo $paginas['pag_tab_id']; ?>">&nbsp;Apagar</a>
     <?php
         }else{
     ?>
            <input name="imagem" type="file" id="imagem" size="43" />
   <?php } ?>   </td>
  </tr>  
  <?php 
        }
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
		/* Ocultar PDF (Ari 09/12/2011)
        $ok = getStatusAtributo($atributos_itens,'arquivo');
        if($ok!=false){
  ?>
  <tr>
    <td class="titulo_noticias">
        <div style="float:left; width: 125px;"><?php echo $ok; ?></div>    
    <?php
	$src = $dados[0]['pdf_src'];
	$caminho = "docs_upload/pdf_48x48.png";
	 if($src!=""){
     ?>
                <img src="<?php echo $caminho; ?>"><a href="php/apagarDocs.php?pasta=produtos&id=<?php echo $id; ?>&pag=<?php echo $paginas['pag_tab_id']; ?>">&nbsp;Apagar</a>
     <?php
         }else{
     ?>
            <input name="pdf" type="file" id="pdf" size="43">
   <?php } ?>   </td>
  </tr>      
  <?php 
        }
		--> AQUI */
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'imagens');
        if($ok!=false){
  ?>
  <tr>
    <td colspan="2" class="titulo_noticias"><hr style="width: 100%"/></td>
  </tr>
  <tr>
    <td colspan="2" align="center" class="titulo_noticias"><h1>Imagens Atuais</h1></td>
    </tr>
  <tr>
    <td colspan="2" class="titulo_noticias">
<?php


if (empty($imagens[0]['pasta'])){
	$msg = "Nenhuma imagem!";
	echo "<span class='msg'>".$msg."</span>";
}else{
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

?>
<!--   CRIAÇÃO DE ALBUNS FLUTUANTE DRAG DROP -->
    <div>
	<!-- 
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
		-->
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
                                        <img src='imagens/".$img['pasta']."/".$pics[$src]."' style='max-width:180px; max-height:120px;' />      
                                    </div>
                                    <center style='background-color:#ECE9E2;'>";
                                            /* $html.="<a href=javascript:editar(".$img['id'].")>
                                                    <img src='./img/edit_16x16.gif' alt='Editar' title='Editar' width='13' height='13' border='0'>
                                                </a>&nbsp;&nbsp;&nbsp;&nbsp;"; */
                                                //<a href=javascript:confirmar(".$img['id'].")>
                                            $html.= "</a>                                     
                                                <a href=javascript:confirmar('php/apagarImagemProd.php?id=".$id."&pasta=".$img['pasta']."&img=".$pics[$src]."&imgid=".$img['id']."&pag=".$paginas['pag_tab_id']."') >
                                                        <img src='./img/excluir.gif' alt='Excluir' title='Excluir' width='13' height='13' border='0'>
                                                </a>
												<div style='width:100%; height: 37px; background:#CCC; margin:0 0 10px 0'>
													<textarea style='width:97%; height:38px; font-size:13px; color:#999;' name='desc' id='desc_".$img['id']."' onblur='javascript:s_legenda(".$img['id'].")' >".$img['legenda']."</textarea>
												</div>
                                    </center>
									
									
                                    
                                </li>";
                        }
               }
               echo $html;	
               ?>
		</ul>
	</div>

<?php		
	
}		



?>
		<script type="text/javascript" src="js/jquery.dragsort-0.4.2.min.js"></script>

		<script type="text/javascript">
			//jQuery.noConflict();
			
                    function geraForm(){
                            var num = document.getElementById('numImg').value;
                            if (num > 0){
                                var url = 'php/geraFormProd.php?num='+num;
                                var myAjax = new Ajax.Updater(
                                'div',
                                url,{method:'post'});
                            }
                    }

                    function limpaForm(){
                            document.getElementById('numImg').options[0].selected=true;
                            document.getElementById('div').innerHTML = "<br /><a style='padding-left:5%;' href='#' onclick='geraForm();'><img src='img/ok16.png' alt='Gerar campos' width='16' height='16' border='0' ><span style='color:#006A01;'>Gerar</span></a>";
                    }

                    function confirmar(query){
                        if(window.confirm("Deseja realmente excluir essa imagem?")){
                            window.location= query;
                            return true;
                        }
                    }

                    function mudaPosicao(img_id,prod_id,sentido){
                        window.location= "php/mudaPosicaoImg.php?id="+img_id+"&prod_id="+prod_id+"&sentido="+sentido+"&tab=prod&pag=<?php echo $paginas['pag_tab_id']; ?>";
                        return true;
                    }
					
					/* ##### CAMPO LEGENDA DE CADA IMAGEM #### */
					function s_legenda(id){
						if (id > 0){
							var valor = document.getElementById('desc_'+id);
							if(valor.value){
								var url = '_update/descimgProd.php';
								var pars = 'id='+id+'&valor='+valor.value;
								var myAjax = new Ajax.Request(
									url,{
										method: 'post',
										parameters: pars
									});
							}
						}
					}
        </script>
    </td>
    </tr>  
<!--  <tr>
    <td height="63" align="center" class="titulo_noticias"><input type="button" value="Atualizar Imagens" class="botao_form" onClick="window.parent.location.href = window.parent.location.href" /></td>
  </tr>-->
  <tr>
    <td align="center" class="titulo_noticias" id="ancor"><br/>
      <iframe src="js/multiupload/produtos_admin.php?id=<?php echo $id; ?>&pag=<?php echo $pag;?>" width="100%" height="400" frameborder="0" allowtransparency="true" style="border: none; margin:0px; padding:0px;">
      <p> Seu navegador não suporta IFrames. <br/>
        Você poderá atualiza-lo ou instalar uma versão mais recente no site do proprietário. <br/>
        http://www.firefox.com <br/>
        http://www.google.com/chrome </p>
      </iframe></td>
  </tr>
  <tr>
    <td height="19" colspan="2" align="left" class="titulo_noticias">
    		
    
    </td>
  </tr>
  <?php 
        }
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'title');
        if($ok!=false){
  ?>
    <tr>
	    <td colspan="2" class="titulo_noticias" align="center">
        	<div style="background:#00579E; width:auto; height:auto; padding:10px 0; margin:20px 0; color:#FFF; line-height:30px;">
                Dicas para um bom posicionamento do seu site nos sites de busca: <a href="http://artwebdigital.com.br/wiki/dicas-seo/dicas-seo.pdf" style="background:#FFF; width:200px; height:30px; text-align:center; line-height:30px; display:block; margin-top:10px;" target="_blank">Dicas de Otimização</a>
			</div>
        </td>
    </tr>
  <tr>
    <td colspan="2" class="titulo_noticias">
        <div style="background-color:#C5CEFA; width: 100%; text-align: center;"><?php echo $ok; ?></div>
          <table>
              <tr>
                  <?php echo '<td class="titulo_noticias" style="font-weight: normal;">Português</td>
                            <td class="titulo_noticias">
                                <textarea name="titlePort" id="titlePort" cols="38" rows="3">'.$dados[0]['title'].'</textarea>
                            </td>';
                        if(count($dados_idioma)>0){
                            $total_criado=1;
                            foreach($dados_idioma as $idioma){
                                if($total_criado==2){
                                    echo '</tr><tr>';
                                    $total_criado=0;
                                }
                                $nome = $idioma['nome'];
                                $sigla=$idioma['sigla'];
                                $titulo=$idioma['title'];                            

                                echo '<td class="titulo_noticias" style="font-weight: normal;">'.$nome.'</td>
                                <td class="titulo_noticias"><label>
                                    <textarea name="title'.$sigla.'" id="title'.$sigla.'" cols="38" rows="3">'.$titulo.'</textarea>
                                </label></td>';
                                $total_criado++;
                            }
                        }else{
                            echo monta_textarea($idiomas,'title');
                        }                           
                        
                        
                  ?>
              </tr>
          </table> 
          <br />
      </td>    
  </tr>  
  <?php 
        }
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'metad');
        if($ok!=false){
  ?>
  <tr>
    <td colspan="2" class="titulo_noticias">
        <div style="background-color:#C5CEFA; width: 100%; text-align: center;"><?php echo $ok; ?></div>
          <table>
              <tr>
                  <?php echo '<td class="titulo_noticias" style="font-weight: normal;">Português</td>
                            <td class="titulo_noticias"><label>
                                <textarea name="metadPort" id="metadPort" cols="38" rows="3">'.$dados[0]['metad'].'</textarea>                                
                            </label></td>';
                        if(count($dados_idioma)>0){
                            $total_criado=1;
                            foreach($dados_idioma as $idioma){
                                if($total_criado==2){
                                    echo '</tr><tr>';
                                    $total_criado=0;
                                }
                                $nome = $idioma['nome'];
                                $sigla=$idioma['sigla'];
                                $titulo=$idioma['metad'];                            

                                echo '<td class="titulo_noticias" style="font-weight: normal;">'.$nome.'</td>
                                <td class="titulo_noticias"><label>
                                    <textarea name="metad'.$sigla.'" id="metad'.$sigla.'" cols="38" rows="3">'.$titulo.'</textarea>                                
                                </label></td>';
                                $total_criado++;
                            }
                        }else{
                            echo monta_textarea($idiomas,'metad');
                        }
                  ?>
              </tr>
          </table> 
          <br />
      </td>    
  </tr>
  <?php 
        }
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'descricao');
        if($ok!=false){
  ?>
   <tr>
    <td colspan="2" class="titulo_noticias">
       <div style="background-color:#C5CEFA; width: 100%; text-align: center;"><?php echo $ok; ?></div>
          <table style="width: 100%;">              
            <tr>
              <td>Português</td>
            </tr>
            <tr>
        <td class="titulo_noticias">  
           
              <?php 
                    echo '<textarea class="editor" name="texto_curtoPort" id="texto_curtoPort" cols="90" rows="3">'.$dados[0]['descricao'].'</textarea>';
              
                    if(count($dados_idioma)>0){    
                        foreach($dados_idioma as $idioma){
                            echo '<tr><td class="titulo_noticias" style="font-weight: normal;">'.$idioma['nome'].'</td>
                                  <td class="titulo_noticias">
                                         <textarea name="texto_curto'.$idioma['sigla'].'" id="texto_curto'.$idioma['sigla'].'" cols="90" rows="3">'.$idioma['descricao'].'</textarea>
                                    </td></tr>';  
                        }
                    }else{
                        foreach($idiomas as $idioma){
                            echo '<tr><td class="titulo_noticias" style="font-weight: normal;">'.$idioma['nome'].'</td>
                                  <td class="titulo_noticias">                                     
                                         <textarea name="texto_curto'.$idioma['sigla'].'" id="texto_curto'.$idioma['sigla'].'" cols="90" rows="3"></textarea>
                                    </td></tr>';
                        }
                    }
                            
              ?>
            </td>
          </tr>
        </table>
      </td>
  </tr>
  <?php 
        }
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'conteudo');
        if($ok!=false){
  ?>
      <tr>
        <td colspan="2" class="titulo_noticias">
            <div style="background-color:#C5CEFA; width: 100%; text-align: center;"><?php echo $ok; ?></div>
            <table style="width: 100%;">              
            <tr>
            	<td>Português</td>
            </tr>
			<tr>
				<td class="titulo_noticias">	
        	<textarea class="editor" id="textoPort" name="textoPort"><?php echo $dados['0']['conteudo']; ?></textarea>
				</td>
			</tr>
				             
					<?php
                   if(count($dados_idioma)>0){
                       foreach($dados_idioma as $idioma){
                      ?>
                      <tr>
							<td>
								<?php echo $idioma['nome']; ?> 
							</td>
						</tr>
						
						<tr>
							<td class="titulo_noticias">
								<textarea id="texto<?php echo $idioma['sigla'];?>" name="texto<?php echo $idioma['sigla'];?>">
									<?php echo $idioma['conteudo']; ?>
								</textarea>
								<script type="text/javascript">
									CKEDITOR.replace('texto<?php echo $idioma['sigla'];?>');
								</script>
								<br />
								<hr/>
							</td>
						</tr>
                      <?php   
                        }
                   }else{
                       foreach($idiomas as $idioma){
                       ?>
                       <tr>
								<td>
									<?php echo $idioma['nome']; ?> 
								</td>
							</tr>
							<tr>
								<td class="titulo_noticias">
									<textarea id="texto<?php echo $idioma['sigla'];?>" name="texto<?php echo $idioma['sigla'];?>">
										<?php echo $idioma['conteudo']; ?>
									</textarea>
									<script type="text/javascript">
										CKEDITOR.replace('texto<?php echo $idioma['sigla'];?>');
									</script>
	                            	<br />
	                            	<hr/>
	                            </td>
							</tr>
                       <?php     
                       }
                   }
                  ?>
          </table>        
    </td>
  </tr>    
  <?php 
        }
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        // $ok = getStatusAtributo($atributos_itens,'cod');
        // if($ok!=false){
  ?>
  <!-- <tr>     -->
    <!-- <td class="titulo_noticias"><br/><div style="float:left; width: 125px;">Código</div><input name="cod" type="text" id="cod" size="20" value="<?php echo $cod; ?>" /></td>   -->
  <!-- </tr> -->
  <?php //} ?>
  <tr>
  <!--
  </tr>
        <tr>    
            <td class="titulo_noticias"><div style="float:left; width: 125px;">Peso</div><input name="peso" type="text" id="peso" size="20" value="<?php echo $dados[0]['peso'] ?>" onkeypress="return Onlynumbers(event)" /> Kg <font size="1">(para calcular o frete)</font></td>
        </tr>
    <tr>
    
    </tr>
        <tr>    
            <td class="titulo_noticias"><div style="float:left; width: 125px;">Estoque</div><input name="quantidade" type="text" id="quantidade" size="20" value="<?php echo $dados[0]['quantidade'] ?>" onkeypress="return Onlynumbers(event)" /> </td>
        </tr>
    <tr>
  -->
  
  </tr>        
  <tr>
    <td align="center" class="titulo_noticias"><input type="submit" value="Atualizar" class="botao_form" /></td>
  </tr>
</table>
</form>
	<script type="text/javascript">
        new Validation('form');
    </script>

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