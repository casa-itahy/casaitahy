<?php 
include("php/sessao.php");
session_write_close();
include_once("includes/functions.php");

$id = $_GET['id'];

$sql = "SELECT * FROM idiomas WHERE status=1 AND sigla!='Port'";
$idiomas = query($sql);

$sql = "(SELECT i.nome, i.sigla,ni.titulo,ni.descricao,ni.conteudo FROM idiomas i 
            LEFT JOIN noticias_idioma ni ON(i.id=ni.idioma_id)
        WHERE i.status=1 AND ni.noticias_id=$id ORDER BY i.id)
        UNION ALL
        (SELECT i.nome, i.sigla,null,null,null
            FROM idiomas i
            WHERE i.status=1 AND i.id!=1
               AND id NOT IN (SELECT idioma_id FROM noticias_idioma WHERE noticias_id=$id)
            ORDER BY i.id)";

//var_dump($sql);die();
$noticias_idioma = query($sql);

$sql = "SELECT * FROM links WHERE tipo = 6 AND lin_id_pg = $id";
$links = query($sql);

$sql = "SELECT * FROM noticias WHERE id=$id ";
$dados = query($sql);

$titulo = htmlspecialchars ($dados[0]['titulo']);

$categorias = query("SELECT * FROM categorias_noticias ORDER BY titulo ASC");

$sqlRec = "SELECT * FROM recados WHERE id_noticia = '$id' ORDER BY id DESC ";
$retornoRec = query($sqlRec);

$atributos_itens = getAtributosItens(2); //11 páginas

?>
<script language ="JavaScript">
function confirmar(query){
	if(window.confirm("Deseja realmente excluir este comentário?"))
	{
		window.location= query;
	   return true;
	}

}
</script>
<script type="text/javascript" src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />

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

<form action="_update/noticias.php" enctype="multipart/form-data" method="post" id="form" >
<input type="hidden" id="tabela" name="tabela" value="noticias" >
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" >
<input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" >
<input type="file" name="fileupload" id="fileupload" style="display: none;" />
<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" align="center"><h1><?php if(isset($_GET['msg'])) { echo $_GET['msg']; } ?></h1></td>
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
       <td colspan="2" class="titulo_noticias">
          <!-- <div style="background-color:#C5CEFA; width: 100%; text-align: center;"><?php echo $ok; ?></div> -->
          <table>              
              <tr>
                  
                  <?php 
                      echo '<td  width="125" style="font-weight: normal;" class="titulo_noticias" style="font-weight: normal;">'.$ok.'</td>';
                      echo '
                            <td class="titulo_noticias"><label>
                                <input name="tituloPort" type="text" id="tituloPort" size="55"  class="required" value="'.$titulo.'" />
                            </label></td>';
                        if(count($noticias_idioma)>0){
                            $total_criado=1;
                            foreach($noticias_idioma as $idioma){                                
                                if($total_criado==2){
                                    echo '</tr><tr>';
                                    $total_criado=0;
                                }
                                
                                $nome = $idioma['nome'];
                                $sigla=$idioma['sigla'];
                                $titulo=$idioma['titulo'];                            

                                echo '<td class="titulo_noticias" style="font-weight: normal;">'.$nome.'</td>
                                <td class="titulo_noticias"><label>
                                    <input name="titulo'.$sigla.'" type="text" id="titulo'.$sigla.'" size="55"  class="required" value="'.$titulo.'" />
                                </label></td>';
                                
                                $total_criado++;
                            }
                        }else{
                            echo monta_input($idiomas, 'titulo');
                        }
                  ?>
              </tr>
          </table> 
      </td>    
  </tr>

    <tr <?php if ($pag != 41): ?> style="display: none;" <?php endif ?>>
        <td colspan="2" class="titulo_noticias">
            <table>              
                <tr>
                    <td class="titulo_noticias" width="125" style="font-weight: normal;">Cor</td>
                    <td class="titulo_noticias">
                        <select name="autor">
                            <option value="">Selecione</option>
                            <option <?php echo ($dados[0]['autor'] == 1) ? 'selected="selected"' : ''; ?> value="1">Laranja</option>
                            <option <?php echo ($dados[0]['autor'] == 2) ? 'selected="selected"' : ''; ?> value="2">Azul</option>
                            <option <?php echo ($dados[0]['autor'] == 3) ? 'selected="selected"' : ''; ?> value="3">Rosa</option>
                        </select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>  

    <tr <?php if ($pag != 5 AND $pag != 40): ?> style="display: none;" <?php endif ?>>
        <td colspan="2" class="titulo_noticias">
            <table>
                <tr>
                    <td class="titulo_noticias" width="125" style="font-weight: normal;">Categoria</td>
                    <td class="titulo_noticias">
                        <select name="categoria" id="categoria">
                            <option value="">Selecione</option>
                            <?php if ($pag == 5): ?>
                              <?php foreach ($categorias as $cat): ?>
                                  <option <?php if ($cat['id'] == $dados[0]['capa']): ?> selected="selected" <?php endif ?> value="<?php echo $cat['id']; ?>"><?php echo $cat['titulo']; ?></option>
                              <?php endforeach ?>
                            <?php else: ?>
                                <option value="1" <?php if ($dados[0]['capa'] == 1): ?> selected="selected" <?php endif ?>>Parceiros</option>
                                <option value="2" <?php if ($dados[0]['capa'] == 2): ?> selected="selected" <?php endif ?>>Clientes</option>
                            <?php endif ?>
                        </select>
                    </td>
                </tr>
            </table>
        </td>
        </td>
    </tr>

    <tr <?php if ($pag != 5): ?> style="display: none;" <?php endif ?>>
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

    <tr <?php echo ($pag == 40 OR $pag == 41) ? 'style="display: none"' : ''; ?>>
	    <td colspan="2" class="titulo_noticias" align="center">
        	<div style="background:#00579E; width:auto; height:auto; padding:10px 0; margin:20px 0; color:#FFF; line-height:30px;">
                Dicas para um bom posicionamento do seu site nos sites de busca: <a href="http://artwebdigital.com.br/wiki/dicas-seo/dicas-seo.pdf" style="background:#FFF; width:200px; height:30px; text-align:center; line-height:30px; display:block; margin-top:10px;" target="_blank">Dicas de Otimização</a>
			</div>
        </td>
    </tr>

    <tr <?php echo ($pag == 40 OR $pag == 41) ? 'style="display: none"' : ''; ?>>
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

    <tr <?php echo ($pag == 40 OR $pag == 41) ? 'style="display: none"' : ''; ?>>
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
        }        
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'imagem');
        if($ok!=false){
  ?>
  <tr>
    <td class="titulo_noticias"><?php echo $ok; ?></td>
    <td class="titulo_noticias">
    
    <?php
	$imagem = $dados[0]['imagem'];
	$caminho = "imagens/noticias/thumb_".$imagem;
	 if($imagem!="")
	 { ?>
     	<img src="<?php echo $caminho; ?>"><a href="php/apagarImagem.php?pasta=noticias&id=<?php echo $id; ?>&pag=<?php echo $paginas['pag_tab_id']; ?>">Apagar</a>
	<?php
     }
	 else
	 {
	?>
      <input name="imagem" type="file" id="imagem" size="43">
      <!-- <?php if ($pag == 5): ?> A imagem deve ter exatamente 800 pixels de largura por 600 pixels de altura. <?php endif ?> -->
    <?php } ?></td>
  </tr>  
<?php if ($pag == 41): ?>
  <tr>
    <td class="titulo_noticias">Ícone</td>
    <td class="titulo_noticias">
    
    <?php
  $icone = $dados[0]['icone'];
  $caminho = "imagens/noticias/icones/thumb_".$icone;
   if($icone!="")
   { ?>
      <img src="<?php echo $caminho; ?>"><a href="php/apagarIconeNoticia.php?pasta=noticias&id=<?php echo $id; ?>&pag=<?php echo $paginas['pag_tab_id']; ?>">Apagar</a>
  <?php
     }
   else
   {
  ?>
      <input name="icone" type="file" id="icone" size="43">
      <br />O ícone deve ser quadrado, com 44 pixels de altura e com a cor selecionada, conforme o layout.
    <?php } ?></td>
  </tr>  
<?php endif; ?>
  <?php 
        }        
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'descricao');
        if($ok!=false){
  ?>
     <tr <?php echo ($pag == 41) ? 'style="display: none"' : ''; ?>>
        <td colspan="2" class="titulo_noticias">
          <div style="background-color:#C5CEFA; width: 100%; text-align: center;">
            <?php echo $ok; ?>
          </div>
           <table>              
              <?php 
                    echo '<tr><td class="titulo_noticias" style="font-weight: normal;">Português</td>
                              <td class="titulo_noticias">
                                     <textarea name="texto_curtoPort" id="texto_curtoPort" cols="90" rows="3">'.$dados[0]['descricao'].'</textarea>
                                </td></tr>';
              
                    if(count($noticias_idioma)>0){    
                        foreach($noticias_idioma as $idioma){
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
          </table> 
        </td>
  </tr>  

  <tr style="display: none;">
      <td colspan="2" class="titulo_noticias">
          <div style="background-color:#C5CEFA; width: 100%; text-align: center;">Tags</div>
          <?php $tagSel = explode(',',$dados[0]['tags']); ?>
          <select name="tags[]" class="custom-select" multiple style="width: 100%;">
              <?php foreach ($tags as $ta): ?>
                  <option <?php echo Selected($ta['id_tag'],$tagSel); ?> value="<?php echo $ta['id_tag']; ?>"><?php echo $ta['texto_tag']; ?></option>
              <?php endforeach ?>
          </select>
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
                   if(count($noticias_idioma)>0){
                       foreach($noticias_idioma as $idioma){
                      ?>
                      <tr>
							<td>
								<?php echo $idioma['nome']; ?> 
							</td>
						</tr>
						
						<tr>
							<td class="titulo_noticias">
								<textarea class="editor" id="texto<?php echo $idioma['sigla'];?>" name="texto<?php echo $idioma['sigla'];?>">
									<?php echo $idioma['conteudo']; ?>
								</textarea>
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
									<textarea class="editor" id="texto<?php echo $idioma['sigla'];?>" name="texto<?php echo $idioma['sigla'];?>">
										<?php echo $idioma['conteudo']; ?>
									</textarea>
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
    <?php } ?>
  <tr>
    <td colspan="2" align="right" class="titulo_noticias">
      <input type="submit" value="Atualizar" class="botao_form">	</td>
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
        	<td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="php/desativar.php?id=<?php echo $x['id']?>&amp;v=0&amp;t=50&idEdit=<?php echo $id?>"><img src="img/olho_visivel.gif" alt="Ativar" border="0"></a></td>
        <?php } else { ?>
       	  <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato"><a href="php/desativar.php?id=<?php echo $x['id']?>&amp;v=1&amp;t=50&idEdit=<?php echo $id?>"><img src="img/olho_oculto.gif" alt="Ativar" border="0"></a></td>
        <?php } ?>
        <td align="center"bgcolor="<?php echo $css; ?>" class="texto_contato">
        <a href="javascript:confirmar('php/excluir.php?id=<?php echo $x['id']?>&t=5&tipo=Noti&idEdit=<?php echo $id?>')"><img src="img/excluir.gif" alt="Excluir" width="17" height="18" border="0"></a></td>
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

function Selected($Valor,$Array){
  if(in_array($Valor,$Array)){
    return 'selected="selected"';
  }
}

?>