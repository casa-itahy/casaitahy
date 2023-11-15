<?php
include("php/sessao.php");
session_write_close();
include_once("includes/functions.php");

$idiomas = query("select sigla,nome FROM idiomas WHERE status=1");

$atributos_itens = getAtributosItens(2); //11 páginas
?>

<script type="text/javascript" src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<form action="_gravar/noticias.php" enctype="multipart/form-data" method="post" id="form" >
    <input type="hidden" id="tabela" name="tabela" value="noticias" >
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
                <td colspan="2" class="titulo_noticias">
                    <table>
                        <th colspan="<?php echo (count($idiomas) * 2); ?>" style="text-align: center;" ><p style="background-color:#C5CEFA;">Pergunta</p></th>
                        <tr>
                            <?php
                            $total_criado = 0;
                            foreach ($idiomas as $idioma) {
                                if ($total_criado == 2) {
                                    echo '</tr><tr>';
                                    $total_criado = 0;
                                }
                                echo '<td class="titulo_noticias" style="font-weight: normal;">' . $idioma['nome'] . '</td>
                                    <td class="titulo_noticias">
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
            <?php
                    }
                    //########### VERIFICA O STATUS DO ATRIBUTO ###################
                    $ok = getStatusAtributo($atributos_itens, 'descricao');
                    if($ok != false){
                ?>
                <tr>
                    <td class="titulo_noticias">
                        <table>
                            <th colspan="2" style="text-align:center;">
                            	<p style="background-color:#C5CEFA;">Resposta</p>
                            </th>
                            <?php
                            foreach ($idiomas as $idioma) {
                                echo '<tr><td class="titulo_noticias" style="font-weight: normal;">' . $idioma['nome'] . '</td>
                                  <td class="titulo_noticias">
                                         <textarea class="editor" name="texto_curto' . $idioma['sigla'] . '" id="texto_curto' . $idioma['sigla'] . '" cols="90" rows="3"></textarea>
                                    </td></tr>';
                            }
                            ?>
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