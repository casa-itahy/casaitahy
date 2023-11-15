<?php 
    include("php/sessao.php");
    
    include_once("includes/functions.php");
    
    $atributos_itens = getAtributosItens(7); //7 produtos
                session_write_close();
                
                $idiomas = query("select sigla,nome FROM idiomas WHERE status=1");

  $tipo = query("SELECT modulo_gemeo FROM modulos WHERE pag_tab_id=".$pag);
  $tipo = $tipo[0]['modulo_gemeo'];

?>

<script type="text/javascript" src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<form action="_gravar/<?php echo $paginas['pag_tab_nome'].'.php'; ?>" enctype="multipart/form-data" method="post" id="form" >
<input type="hidden" id="tabela" name="tabela" value="<?php echo $paginas['pag_tab_nome']; ?>" >
<input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" >
<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><h1> 
    <?php
        echo $paginas['titulo'];
            session_write_close();
    ?>
    </h1></td>
  </tr>
  
    
<?php
//########### VERIFICA O STATUS DO ATRIBUTO ###################
$ok = getStatusAtributo($atributos_itens, 'tituloCate');
if ($ok != false) {
?>   
  <tr>
      <td colspan="2" class="titulo_noticias">
          <table>
              <th colspan="<?php echo (count($idiomas)*2); ?>" style="text-align: center;" ><p style="background-color:#C5CEFA;">T&iacute;tulo</p></th>
              <tr>
                  <?php $total_criado=0;
                        foreach($idiomas as $idioma){
                            if($total_criado==2){
                                echo '</tr><tr>';
                                $total_criado=0;
                            }
                            echo '<td class="titulo_noticias" style="font-weight: normal;">'.$idioma['nome'].'</td>
                            <td class="titulo_noticias"><label>
                                <input name="titulo'.$idioma['sigla'].'" type="text" id="titulo'.$idioma['sigla'].'" size="55"  class="required">
                            </label></td>';
                            $total_criado++;
                        }
                  ?>
              </tr>
          </table> 
          <br />
      </td>
  </tr>

  <tr>
    <td class="titulo_noticias" width="80">Sub título</td>
    <td class="titulo_noticias">
      <input name="subtitulo" type="text" size="55">
      <span style="font-weight: normal;">(Exibido na página de listagem dos exames)</span>
   </td>
  </tr>
  <tr>
    <td class="titulo_noticias" width="80">Valor</td>
    <td class="titulo_noticias">
      <input name="textoPort" type="text" size="55" />
   </td>
  </tr>
  <tr class="inputFile">
    <td class="titulo_noticias" width="150">Imagem</td>
    <td class="titulo_noticias">
      <input name="imagem" type="file" id="imagem" size="43">
   </td>
  </tr>
  <tr class="inputFile">
      <td class="titulo_noticias">Descrição Curta:</td>
      <td>
        <textarea id="descricao" name="descricao" rows="4" cols="50"></textarea>
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
                            <textarea name="title" id="title" cols="50" rows="3"></textarea>
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
$ok = getStatusAtributo($atributos_itens, 'subCategoriaDe');
if ($ok != false) {
?>   
  
  <tr>
    <td class="titulo_noticias" width="150" >Sub-sessão de:</td>
    <td  class="titulo_noticias">
       <select name="pai" id="pai" onchange="Teste()" class="validate-selection">
          <option value="">-- Nenhuma --</option>
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
                        AND cs.tipo = ".$tipo."
                        ORDER BY cs.posicao";
                $categorias = query($sql);
                
    foreach ($categorias  as $r){
      echo "<option data-Id=".$r[id]." value=".$r[id].">".$r[titulo]."</option>";
                        //BUSCA FILHOS
      $sql ="SELECT c.id, csn.cat_filho_id, c.titulo, c.status
                                   FROM categorias_subcat c
                                   LEFT JOIN cat_subcat_nivel csn ON (c.id=csn.cat_filho_id)
                                   WHERE csn.cat_pai_id='".$r['id']."'
                                   AND csn.cat_neto_id IS NULL
                                   ORDER BY c.posicao ASC";
                        $catFilho_array=query($sql);                        
      foreach ($catFilho_array as $f){
                          //  echo "<option value=".$r[id].'-'.$f[id].">-- ".$f[titulo]."</option>";
      }
    }
    ?>    
      </select>    
    </td>
  </tr>
  <tr class="inputFileFilho" style="display: none;">
    <td class="titulo_noticias" width="150">Forma de Exibição</td>
    <td class="titulo_noticias">
      <select name="exibicao" id="exibicao" class="validate-selection">
        <option value="">Selecione</option>
        <option value="1">Texto acima e imagem abaixo.</option>
        <option value="2">Chamada e Botão CTA.</option>
        <option value="3">Caixas Recursos (sandwich).</option>
      </select>
   </td>
  </tr>
  <tr class="inputFileFilho" style="display: none;">
    <td class="titulo_noticias" width="150">Exibir Titulo da Sessão?</td>
    <td class="titulo_noticias">
      <input type="radio" checked="checked" name="mostraTitulo" value="1" /> Sim
      <input type="radio" name="mostraTitulo" value="0" /> Não
      | <span style="font-weight: normal;">Não é exibido quando a opção "Chamada e Botão CTA." é selecionada.</span>
   </td>
  </tr>
<?php
}
//########### VERIFICA O STATUS DO ATRIBUTO ###################
$ok = getStatusAtributo($atributos_itens, 'conteudoCate');
if ($ok != false) {
?>   

<!--   <tr style="display: none;">
      <td class="titulo_noticias" colspan="2">
          <table style="width: 100%;">
              <th colspan="2" style="text-align:center;"><p style="background-color:#C5CEFA;">Conte&uacute;do</p></th>
                <?php     
                    foreach($idiomas as $idioma){
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
                                  
                             <?php }
                  ?>
          </table> 
    </td>      
  </tr> -->
<?php } ?>
  <tr>
    <td colspan="2" align="right" class="titulo_noticias">
      <input type="submit" value="Salvar" class="botao_form"> </td>
  </tr>
</table>
</form>
  <script type="text/javascript">
    jQuery(document).ready(function(){
      jQuery("#pai").change(function(){
        var categoria = jQuery(this).val();
        if(categoria == '0'){
          jQuery(".inputFile").show();
          jQuery(".inputFileFilho").hide();
        }else{
          jQuery(".inputFile").hide();
          jQuery(".inputFileFilho").show();
        }
      });
    });
        new Validation('form');
    </script>