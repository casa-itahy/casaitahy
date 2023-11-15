<?php 
include_once("php/sessao.php");
session_write_close();

    include_once("includes/functions.php");

$atributos_itens = getAtributosItens(7); //7 produtos

$id = $_GET['id'];
$id_old=$id;

$valores = explode('-',$id);

if(isset($valores[1])){
    $pai = $valores[0];
    $filho = $valores[1];
    if(isset($valores[2]))
        $id=$valores[2];
    else
        $id=$valores[1];
}else{
    $pai = $valores[0];
    $id=$valores[0];
    $filho='NULL';
}


$sql = "SELECT * FROM idiomas WHERE status=1 AND sigla!='Port'";
$idiomas = query($sql);

$sql = "SELECT ci.*,i.nome, i.sigla FROM categorias_idioma ci                 
            LEFT JOIN idiomas i ON(ci.idioma_id=i.id)    
        WHERE ci.categoria_id=$id ORDER BY i.id";

$sql = "(SELECT i.nome, i.sigla,ci.titulo,ci.conteudo FROM idiomas i 
            LEFT JOIN categorias_idioma ci ON(i.id=ci.idioma_id)
        WHERE i.status=1 AND ci.categoria_id=$id ORDER BY i.id)
        UNION ALL
        (SELECT i.nome, i.sigla,null,null
            FROM idiomas i
            WHERE i.status=1 AND i.id!=1
               AND id NOT IN (SELECT idioma_id FROM categorias_idioma WHERE categoria_id=$id)
            ORDER BY i.id)";

$categorias_idioma = query($sql);

$sql = "SELECT * FROM categorias_subcat WHERE id=$id ";
$dados = query($sql);

$titulo = htmlspecialchars($dados[0]['titulo']);

$IdPai = $dados[0]['id'];
$SelecionaCategorias = query("SELECT * FROM cat_subcat_nivel WHERE cat_pai_id = '$IdPai'");
$CatPai = count($SelecionaCategorias);

$sql = "SELECT * FROM links WHERE tipo = 3 AND lin_id_pg = $id";
$links = query($sql);
?>
<script type="text/javascript" src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<form action="_update/<?php echo $paginas['pag_tab_nome'].'.php'; ?>" enctype="multipart/form-data" method="post" id="form" >
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" >
<input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" >
<input type="hidden" name="oldpai" id="oldpai" value="<?php echo $id_old;?>" />
<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
        <h1>Editar
            <?php                
    echo $paginas['titulo'];
    session_write_close();
            ?>
        </h1>
    </td>
  </tr>  
  <tr>
    <td height="15" colspan="2" align="center"></td>
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
                        if(count($categorias_idioma)>0){
                            $total_criado=1;
                            foreach($categorias_idioma as $idioma){
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
          <br />
      </td>    
  </tr>
  <tr>
    <td class="titulo_noticias" width="80">Sub título</td>
    <td class="titulo_noticias">
      <input name="subtitulo" type="text" size="55" value="<?php echo $dados[0]['subtitulo']; ?>">
      <span style="font-weight: normal;">(Exibido na página de listagem dos exames)</span>
   </td>
  </tr>
  <tr>
    <td class="titulo_noticias" width="80">Valor</td>
    <td class="titulo_noticias">
      <input name="textoPort" type="text" size="55" value="<?php echo $dados[0]['conteudo']; ?>">
   </td>
  </tr>
  <tr>
      <td class="titulo_noticias">Descrição Curta:</td>
      <td>
        <textarea id="descricao" name="descricao" rows="4" cols="50"><?php echo $dados[0]['descricao']; ?></textarea>
      </td>
  </tr>

<?php if($CatPai > 0){ ?>
  <tr class="inputFile">
    <td class="titulo_noticias">Imagem</td>
    <td class="titulo_noticias">

    <?php
    $imagem = $dados[0]['imagem'];
    $caminho = "imagens/categorias_subcat/thumb_".$imagem;
    if($imagem!=""){
  ?>
       <img src="<?php echo $caminho; ?>"><a href="php/apagarImagem.php?pasta=categorias&id=<?php echo $id; ?>&pag=<?php echo $paginas['pag_tab_id']; ?>" >&nbsp;Apagar</a>
  <?php } else { ?>
        <input name="imagem" type="file" id="imagem" size="43">
    <?php  } ?>
   </td>
  </tr>
<?php } ?>

    <tr>
      <td colspan="2" class="titulo_noticias" align="center">
          <div style="background:#00579E; width:auto; height:auto; padding:10px 0; margin:20px 0; color:#FFF; line-height:30px;">
                Dicas para um bom posicionamento do seu site nos sites de busca: <a href="http://artwebdigital.com.br/wiki/dicas-seo/dicas-seo.pdf" style="background:#FFF; width:200px; height:30px; text-align:center; line-height:30px; display:block; margin-top:10px;" target="_blank">Dicas de Otimização</a>
      </div>
        </td>
    </tr>

    <tr>
        <td colspan="2" class="titulo_noticias">
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
  <tr>
    <td class="titulo_noticias"  width="150">&nbsp;</td>
    <td class="titulo_noticias">&nbsp;</td>
    <td class="titulo_noticias">&nbsp;</td>
  </tr>
  <?php
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens, 'subCategoriaDe');
        if ($ok != false) {
    ?>   
    
      <tr style="display: none;">
        <td class="titulo_noticias"  width="150"><p>Sub-Sessão de</p></td>
        <td class="titulo_noticias">    
        <select name="pai" id="pai" >
            <option value="0">-- Nenhuma --</option>
                <?php
                      /*#############################################
              * ##### BUSCA TODAS AS CATEGORIAS PAI ########
                       ####################################*/
                    $sql = "SELECT cs.id,cs.titulo,cs.status,cs.posicao
                            FROM categorias_subcat cs
                            RIGHT JOIN cat_subcat_nivel csn ON (cs.id = csn.cat_pai_id)
                            WHERE csn.cat_filho_id IS NULL
                            AND csn.cat_neto_id IS NULL
                            AND csn.sub_cat_id IS NULL
                            AND cs.id <> $id
                            ORDER BY cs.posicao";
                    $categorias = query($sql);
    
                    $selected='';
            foreach ($categorias  as $r){
                            //BUSCA FILHOS
                $sql ="SELECT c.id, csn.cat_filho_id, c.titulo, c.status
                                       FROM categorias_subcat c
                                       LEFT JOIN cat_subcat_nivel csn ON (c.id=csn.cat_filho_id)
                                       WHERE csn.cat_pai_id='".$r['id']."'
                                       and csn.cat_neto_id IS NULL
                                       ORDER BY c.posicao ASC";
                            $catFilho_array=query($sql);
                            if(count($catFilho_array)>0){
                               $cat = "<option value='".$r[id]."'>->".$r[titulo]."</option>";
                               $subCat='';
                               foreach ($catFilho_array as $f){
                                    if($f[id]==$id){
                                        $cat = "<option selected='selected' value='".$r[id]."'>->".$r[titulo]."</option>";
                                    }else{                                   
                                       $sql ="SELECT c.id, csn.cat_filho_id, csn.cat_neto_id, c.titulo, c.status
                                       FROM categorias_subcat c
                                       LEFT JOIN cat_subcat_nivel csn ON (c.id=csn.cat_filho_id)
                                       WHERE csn.cat_neto_id='".$id."' AND csn.cat_filho_id='".$f[id]."' LIMIT 1";
                                       $catNeto_array=query($sql);
                                        if(count($catNeto_array)>0){
                                            //if($catNeto_array[0][cat_pai_id]==$id)
                                            $subCat .= "<option selected='selected' value='".$r[id].'-'.$f[id]."'>&nbsp;&nbsp;&nbsp;&nbsp;-->".$f[titulo]."</option>";
                                            //echo "<option selected='selected' value=".$catNeto_array[0][id].'-'.$catNeto_array[0][cat_filho_id].">&nbsp;&nbsp;&nbsp;&nbsp;-->".$catNeto_array[0][titulo]."</option>";
                                        }else{
                                            $subCat .= "<option value='".$r[id].'-'.$f[id]."'>&nbsp;&nbsp;&nbsp;&nbsp;-->".$f[titulo]."</option>";
                                        }
                                    }
                                }
                                echo $cat.$subCat;
                            }else{
                                echo "<option  value='".$r[id]."'>->".$r[titulo]."</option>";
                            }
            }
          ?>
    
          </select></td>
        <td class="titulo_noticias">&nbsp;</td>
      </tr>
    <?php } ?>

<?php if ($pag != 38): ?>
  <tr class="inputFile" style="display: none;">
    <td class="titulo_noticias" width="150">Vídeo</td>
    <td class="titulo_noticias">
      <input name="video" type="text" id="video" size="55" value="<?php echo $dados[0]['video']; ?>" />
   </td>
  </tr>
  <tr class="inputFileFilho" <?php if($CatPai > 0){ ?>style="display: none;"<?php } ?>>
    <td class="titulo_noticias" width="150">Forma de Exibição</td>
    <td class="titulo_noticias">
      <select name="exibicao" id="exibicao" class="validate-selection">
        <option value="">Selecione</option>
        <option value="1" <?php if ($dados[0]['exibicao'] == 1): ?>selected="selected"<?php endif ?>>Texto acima e imagem abaixo.</option>
        <option value="2" <?php if ($dados[0]['exibicao'] == 2): ?>selected="selected"<?php endif ?>>Chamada e Botão CTA.</option>
        <option value="3" <?php if ($dados[0]['exibicao'] == 3): ?>selected="selected"<?php endif ?>>Caixas Recursos (sandwich).</option>
      </select>
   </td>
  </tr>
  <tr class="inputFileFilho" <?php if($CatPai > 0){ ?>style="display: none;"<?php } ?>>
    <td class="titulo_noticias" width="150">Exibir Titulo da Sessão?</td>
    <td class="titulo_noticias">
      <input type="radio" <?php if ($dados[0]['mostraTitulo'] == 1): ?>checked="checked"<?php endif ?> name="mostraTitulo" value="1" /> Sim
      <input type="radio" <?php if ($dados[0]['mostraTitulo'] == 0): ?>checked="checked"<?php endif ?> name="mostraTitulo" value="0" /> Não
      <span style="font-weight: normal;">Não é exibido quando a opção "Chamada e Botão CTA." é selecionada.</span>
   </td>
  </tr>
<?php endif; ?>

<?php
//########### VERIFICA O STATUS DO ATRIBUTO ###################
$ok = getStatusAtributo($atributos_itens, 'conteudoCate');
if ($ok != false) {
?>   
<!--   <tr style='display: none;'>
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
                   if(count($categorias_idioma)>0){
                       foreach($categorias_idioma as $idioma){
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
  </tr>     -->
<?php } ?>
  <tr>
    <td colspan="2" align="right" class="titulo_noticias">
      <input type="submit" value="Atualizar" class="botao_form">  </td>
  </tr>
</table>
</form>
  <script type="text/javascript">
        new Validation('form');
    </script>
    <?php 
function monta_input($idiomas,$nome){
    foreach($idiomas as $item){
        echo '<td class="titulo_noticias" style="font-weight: normal;">'.$item['nome'].'</td>
              <td class="titulo_noticias"><label>
                    <input name="'.$nome.$item['sigla'].'" type="text" id="'.$nome.$item['sigla'].'" size="55" /></label>
              </td>';
    }
}
?>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
      $("#pai").change(function(){
        var categoria = $(this).val();
        if(categoria == '0'){
          $(".inputFile").show();
          $(".inputFileFilho").hide();
        }else{
          $(".inputFile").hide();
          $(".inputFileFilho").show();
        }
      });
    });
  new Validation('form');
</script>