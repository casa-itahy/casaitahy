<?php
include("php/sessao.php");
session_write_close();
include_once("includes/functions.php");

$idiomas = query("select sigla,nome FROM idiomas WHERE status=1");

$atributos_itens = getAtributosItens(2); //11 páginas

$categorias = query("SELECT * FROM categorias_noticias ORDER BY titulo ASC");

?>

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

<form action="_gravar/noticias.php" enctype="multipart/form-data" method="post" id="form" >
    <input type="hidden" id="tabela" name="tabela" value="noticias" >
    <input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" >
    <input type="file" name="fileupload" id="fileupload" style="display: none;" />
    <table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" align="center"><h1>Incluir     
                    <?php
                    echo $paginas['titulo'];
                    session_write_close();
                    ?>
                </h1></td>
        </tr>  
        <?php
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens, 'titulo');
        if ($ok != false) {
            $total_criado = 0;
            ?>
            <tr>
                <td colspan="2" class="titulo_noticias">
                    <table>
                        <th colspan="<?php echo (count($idiomas) * 2); ?>" style="text-align: center;" ><p style="background-color:#C5CEFA;"></p></th>
                        <tr>
                            <?php
                            foreach ($idiomas as $idioma) {
                                if ($total_criado == 2) {
                                    echo '</tr><tr>';
                                    $total_criado = 0;
                                }
                                echo '<td  width="125" style="font-weight: normal;" class="titulo_noticias" style="font-weight: normal;">'.$ok.'</td>';
                                echo '<td class="titulo_noticias">
                                        <label>
                                            <input name="titulo' . $idioma['sigla'] . '" type="text" id="titulo' . $idioma['sigla'] . '" size="55"  class="required">
                                        </label></td>';
                                $total_criado++;
                            }
                            ?>
                        </tr>
                    </table> 
                    <br />
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
                            <option value="1">Laranja</option>
                            <option value="2">Azul</option>
                            <option value="3">Rosa</option>
                        </select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>  

    <tr <?php if ($pag != 5): ?> style="display: none;" <?php endif ?>>
        <td colspan="2" class="titulo_noticias">
            <br />
            <table>              
                <tr>
                    <td class="titulo_noticias" width="125" style="font-weight: normal;">Data</td>
                    <td class="titulo_noticias">
                        <input type="text" class='required' id="datepicker" size="10" name="created" />
                    </td>
                </tr>
            </table>
        </td>
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
                                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['titulo']; ?></option>
                                <?php endforeach ?>
                            <?php else: ?>
                                <option value="1">Parceiros</option>
                                <option value="2">Clientes</option>
                            <?php endif ?>
                        </select>
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
                            <textarea name="title" id="title" cols="50" rows="3"></textarea>
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
                            <textarea name="metad" id="metad" cols="50" rows="3"></textarea>
                        </label>
                    </td>
                </tr>
            </table>
        </td>
    </tr>  

            <?php
                }
                //########### VERIFICA O STATUS DO ATRIBUTO ###################
                $ok = getStatusAtributo($atributos_itens, 'imagem');
                if ($ok != false) {
            ?>
                <tr>
                    <td class="titulo_noticias" align="center"><p style="background-color:#C5CEFA;"><?php echo $ok; ?></td>
                </tr>
                <tr>
                    <td class="titulo_noticias" align="center">
                        <input name="imagem" type="file" id="imagem" size="43">
<!--                         <?php if ($pag == 5): ?> A imagem deve ter exatamente 800 pixels de largura por 600 pixels de altura. <?php endif ?>
 -->                    </td>
                </tr>

                <?php if ($pag == 41): ?>
                    <tr>
                        <td class="titulo_noticias" align="center"><p style="background-color:#C5CEFA;">Ícone</td>
                    </tr>
                    <tr>
                        <td class="titulo_noticias" align="center">
                            <input name="icone" type="file" id="icone" size="43"><br />
                            O ícone deve ser quadrado, com 44 pixels de altura e com a cor selecionada, conforme o layout.
                        </td>
                    </tr>
                <?php endif ?>

                <?php
                    }
                    //########### VERIFICA O STATUS DO ATRIBUTO ###################
                    $ok = getStatusAtributo($atributos_itens, 'descricao');
                    if($ok != false){
                ?>
                <tr <?php if ($pag == 41): ?> style="display: none;" <?php endif ?>>
                    <td class="titulo_noticias">
                        <table>
                            <th colspan="2" style="text-align:center;">
                            	<p style="background-color:#C5CEFA;">
                                    <?php echo $ok; ?>
                                </p>
                            </th>
                            <?php
                            foreach ($idiomas as $idioma) {
                                echo '<tr><td class="titulo_noticias" style="font-weight: normal;">' . $idioma['nome'] . '</td>
                                  <td class="titulo_noticias">
                                         <textarea name="texto_curto' . $idioma['sigla'] . '" id="texto_curto' . $idioma['sigla'] . '" cols="90" rows="3"></textarea>
                                    </td></tr>';
                            }
                            ?>
                        </table> 
                    </td>  
                </tr>

              <tr style="display: none;">
                  <td class="titulo_noticias">
                        <div style="background-color:#C5CEFA; width: 100%; text-align: center;">Tags</div>
                        <select name="tags[]" class="custom-select" multiple style="width: 100%;">
                            <?php foreach ($tags as $ta): ?>
                                <option value="<?php echo $ta['id_tag']; ?>"><?php echo $ta['texto_tag']; ?></option>
                            <?php endforeach ?>
                        </select>
                  </td>
              </tr>

                <?php
                    }
                    //########### VERIFICA O STATUS DO ATRIBUTO ###################
                    $ok = getStatusAtributo($atributos_itens, 'conteudo');
                    if($ok != false){
                ?>
				<tr>
					<td class="titulo_noticias">
                        <table style="width: 100%;">
                            <th colspan="2" style="text-align:center;" >
                            	<p style="background-color:#C5CEFA;">
                            		<?php echo $ok; ?>
                            	</p>
                            </th>
                            <?php
                                foreach ($idiomas as $idioma) {
                             ?>
                                	<tr>
                                		<td class="titulo_noticias">
                                			<?php echo $idioma['nome'];?>
                                		</td>
                                	</tr>
                                	<tr>
                                		<td>
                                			<textarea class="editor" id="texto<?php echo $idioma['sigla'];?>" name="texto<?php echo $idioma['sigla'];?>"></textarea>
                                		</td>
                                	</tr>
                                	
                             <?php  } ?>
						</table> 
		            </td>      
		        </tr>
        <?php
            }            
        ?>
        <tr>
            <td align="right" class="titulo_noticias">
                <input type="submit" value="Incluir" class="botao_form">	</td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    new Validation('form');
</script>