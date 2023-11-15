<?php
include("php/sessao.php");
session_write_close();

include_once("includes/functions.php");

$idiomas = query("select sigla,nome FROM idiomas WHERE status=1");

$atributos_itens = getAtributosItens(7); //7 produtos

?>

<script type="text/javascript" src="js/modulos_js/formataReais.js"></script>

<script type="text/javascript" src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<form action="_gravar/produtos.php" enctype="multipart/form-data" method="post" id="form" >
    <input type="hidden" id="tabela" name="tabela" value="produtos" >
    <input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" >
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
    ?>    
            <tr>
                <td height="15" colspan="2" align="center"></td>
            </tr>
            <tr>
                <td colspan="2" class="titulo_noticias">
                    <div style="background-color:#C5CEFA; width: 100%; text-align: center;"><?php echo $ok; ?></div>
                    <table>
                        <tr>
    <?php
    $total_criado = 0;
    foreach ($idiomas as $idioma) {
        if ($total_criado == 2) {
            echo '</tr><tr>';
            $total_criado = 0;
        }
        echo '<td class="titulo_noticias" style="font-weight: normal;">' . $idioma['nome'] . '</td>
                            <td class="titulo_noticias"><label>
                                <input name="titulo' . $idioma['sigla'] . '" type="text" id="titulo' . $idioma['sigla'] . '" size="51"  class="required">
                            </label></td>';
        $total_criado++;
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
        $ok = getStatusAtributo($atributos_itens, 'categoria');
        if ($ok != false) {
            ?>  
            <tr>
                <td class="titulo_noticias"><div style="float:left; width: 125px;"><?php echo $ok; ?></div><select name="categoria" id="categoria" class="validate-selection">
                        <option>-- Escolha --</option>
                        <?php
                        /* #############################################
                         * ##### BUCA TODAS AS CATEGORIAS PAI ########
                          #################################### */
                        $sql = "SELECT cs.id,cs.titulo,cs.status,cs.posicao
                        FROM categorias_subcat cs
                        RIGHT JOIN cat_subcat_nivel csn ON (cs.id = csn.cat_pai_id)
                        WHERE csn.cat_filho_id IS NULL
                        AND csn.cat_neto_id IS NULL
                        AND csn.sub_cat_id IS NULL
                        ORDER BY cs.posicao";
                        $categorias = query($sql);
                        

                        foreach ($categorias as $r) {
                            echo "<option value=" . $r['id'] . ">" . $r['titulo'] . "</option>";
                            //BUSCA FILHOS
                            $sql = "SELECT c.id, csn.cat_filho_id, c.titulo, c.status
                                   FROM categorias_subcat c
                                   LEFT JOIN cat_subcat_nivel csn ON (c.id=csn.cat_filho_id)
                                   WHERE csn.cat_pai_id='" . $r['id'] . "'
                                   AND csn.cat_neto_id IS NULL
                                   ORDER BY c.posicao ASC";
                            $catFilho_array = query($sql);
                            
                            foreach ($catFilho_array as $f) {
                                 echo "<option value=" . $f['id'] . ">-- " . $f['titulo'] . "</option>";
                                
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
                                        echo "<option value=".$catNeto['id'].">---- ".$catNeto['titulo'] . "</option>";
                                     }
                                 }
                            }
                        }
                        ?>
                    </select></td>    
            </tr>
<!--             <tr>
                <td class="titulo_noticias">&nbsp;</td>
            </tr>
            <tr style="display: none;">
                <td class="titulo_noticias"><strong>Campos CTA</strong></td>
            </tr>
            <tr style="display: none;">
                <td class="titulo_noticias">
                    <div style="float:left; width: 125px;">Texto do Botão</div>
                    <input name="textoBotao" type="text" id="textoBotao" size="51" />
                </td>
            </tr>
            <tr style="display: none;">
                <td class="titulo_noticias">
                    <div style="float:left; width: 125px;">Link do Botão</div>
                    <input name="linkBotao" type="text" id="linkBotao" size="51" />
                </td>
            </tr> -->
            <tr style="display: none;">
                <td class="titulo_noticias">
                    <div style="float:left; width: 125px;">Abrir Link</div>
                    <input type="radio" checked="checked" name="target" value="1" /> Mesma Janela
                    <input type="radio" name="target" value="2" /> Nova Janela
                </td>
            </tr>
            <tr>
                <td class="titulo_noticias">&nbsp;</td>
            </tr>

            <?php
        }
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens, 'imagem');
        if ($ok != false) {
            ?>  
            <tr>
                <td class="titulo_noticias"><div style="float:left; width: 125px;"><?php echo $ok; ?></div>
                    <input name="imagem" type="file" id="imagem" size="43">
                </td>
            </tr>
            <?php
        }
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
		/* Ocultar PDF (Ari 09/12/2011)
        $ok = getStatusAtributo($atributos_itens, 'arquivo');
        if ($ok != false) {
            ?>  
            <tr>
                <td class="titulo_noticias"><div style="float:left; width: 125px;">Arquivo PDF </div>
                    <input name="pdf" type="file" id="pdf" size="43">			
                </td>
            </tr>
            <?php
        }
		--> AQUI */
        //########### VERIFICA O STATUS DO ATRIBUTO ###################

            ?>  
            <tr>
                <td colspan="2" class="titulo_noticias"></td>
            </tr>
            <?php
                //########### VERIFICA O STATUS DO ATRIBUTO ###################
                $ok = getStatusAtributo($atributos_itens, 'title');
                if($ok != false){
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
                            <?php
                            $total_criado = 0;
                            foreach ($idiomas as $idioma) {
                                if ($total_criado == 2) {
                                    echo '</tr><tr>';
                                    $total_criado = 0;
                                }
                                echo '<td class="titulo_noticias" style="font-weight: normal;">' . $idioma['nome'] . '</td>
                            <td class="titulo_noticias"><label>
                                <input name="title' . $idioma['sigla'] . '" type="text" id="title' . $idioma['sigla'] . '" size="50"  class="required">
                            </label></td>';
                                $total_criado++;
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
                $ok = getStatusAtributo($atributos_itens, 'metad');
                if($ok != false){
            ?>  
            <tr>
                <td colspan="2" class="titulo_noticias">
                    <div style="background-color:#C5CEFA; width: 100%; text-align: center;"><?php echo $ok; ?></div>
                    <table>              
                        <tr>
                            <?php
                            $total_criado = 0;
                            foreach ($idiomas as $idioma) {
                                if ($total_criado == 2) {
                                    echo '</tr><tr>';
                                    $total_criado = 0;
                                }
                                echo '<td class="titulo_noticias" style="font-weight: normal;">' . $idioma['nome'] . '</td>
                            <td class="titulo_noticias"><label>
                                <textarea name="metad' . $idioma['sigla'] . '" id="metad' . $idioma['sigla'] . '" cols="38" rows="3"></textarea>
                            </label></td>';
                                $total_criado++;
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
                $ok = getStatusAtributo($atributos_itens, 'descricao');
                if($ok != false){
            ?>
            <tr style="display: none;">
                <td class="titulo_noticias">
                    <table>
                        <th colspan="2" style="text-align:center;"><p style="background-color:#C5CEFA;"><?php echo $ok; ?></p></th>
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
            <?php
                }
                //########### VERIFICA O STATUS DO ATRIBUTO ###################
                $ok = getStatusAtributo($atributos_itens, 'conteudo');
                if($ok != false){
            ?>
            <tr style="display: none;">
                <td class="titulo_noticias">
                    <div style="background-color:#C5CEFA; width: 100%; text-align: center;"><?php echo $ok; ?></div>
                    <table style="width: 100%;">              
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
                                			<textarea class="editor" id="texto<?php echo $idioma['sigla'];?>" name="texto<?php echo $idioma['sigla'];?>">
<table style="border-collapse: collapse; width: 100%;" border="1">
<tbody>
<tr>
<td style="width: 50%;">
<p>&Aacute;rea de servi&ccedil;o<br />Arm&aacute;rio &aacute;rea de Servi&ccedil;o<br />Arm&aacute;rio banheiro<br />Arm&aacute;rio cozinha<br />Arm&aacute;rio dormit&oacute;rio de empregada<br />Arm&aacute;rio quarto<br />Arm&aacute;rio sala<br />Copa</p>
</td>
<td style="width: 50%;">Cozinha<br />Despensa<br />Dormit&oacute;rio de empregada<br />Elevador<br />Escrit&oacute;rio<br />Interfone<br />Lavanderia<br />Piso cer&acirc;mico</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
                                            </textarea>
                                		</td>
                                	</tr>
                                	
                             <?php } ?>
                </table> 
            </td>      
        </tr>
        <?php
                }

                $ok = getStatusAtributo($atributos_itens, 'cod');
                if($ok != false){
            ?>
                    <tr>    
                        <td class="titulo_noticias"><div style="float:left; width: 125px;"><?php echo $ok; ?></div><input name="cod" type="text" id="cod" size="20" /></td>
                    </tr>
        <?php } ?>
        <tr>
        <!--
        </tr>
            <tr>    
                <td class="titulo_noticias"><div style="float:left; width: 125px;">Peso</div><input name="peso" type="text" id="peso" size="20" onkeypress="return Onlynumbers(event)" /> Kg <font size="1">(para calcular o frete)</font></td>
            </tr>
        <tr>
        
        </tr>
            <tr>    
                <td class="titulo_noticias"><div style="float:left; width: 125px;">Estoque</div><input name="quantidade" type="text" id="quantidade" size="20" onkeypress="return Onlynumbers(event)" /> </td>
            </tr>
        <tr>
        -->
                </tr>
        <?php

                $ok = getStatusAtributo($atributos_itens, 'valor');
                if($ok != false){
            ?>
                    <tr style="display: none;">
                        <td class="titulo_noticias"><div style="float:left; width: 125px;"><?php echo $ok; ?></div><input name="valor" type="text" id="valor" size="20" length=15 /></td>
                        <!-- onkeypress="reais(this,event)" onkeydown="backspace(this,event)" -->
                    </tr>
                    <tr style="display: none;">
                        <td class="titulo_noticias"><div style="float:left; width: 125px;">Valor Associado</div><input name="valor2" type="text" id="valor2" size="20" length=15 /></td>
                        <!-- onkeypress="reais(this,event)" onkeydown="backspace(this,event)" -->
                    </tr>
        <?php } ?>
        <tr>
            <td align="center" class="titulo_noticias">
                <br/>
                <input type="submit" value="Salvar e Cadastrar Conteúdo" class="botao_form">
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    new Validation('form');
</script>