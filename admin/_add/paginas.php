<?php


include_once("php/sessao.php");
$user_id = $_SESSION['id'];
session_write_close();


include_once("includes/functions.php");

$idiomas = query("select sigla,nome FROM idiomas WHERE status=1");


if ($user_id == 1) {

  $sql = "SELECT id, titulo, indice, pag_tab_id FROM
                            modulos WHERE status=1 AND status_conteudo_simples=1                      
                            AND id NOT IN (SELECT p.tipo FROM paginas p INNER JOIN modulos m ON(p.tipo=m.id) WHERE m.repete_pagina!=1)
                            ORDER BY titulo";//AND id NOT IN (SELECT p.tipo FROM paginas p)
} else {

  $sql = "SELECT modu.id, modu.titulo, modu.indice, modu.pag_tab_id 
                                FROM usuarios_modulos um
                                LEFT JOIN modulos modu ON (um.modulo_id = modu.id)
                                WHERE um.usuario_id='" . $user_id . "' 
                                        AND modu.status=1 
                                        AND modu.status_conteudo_simples=1
                                        AND id NOT IN (SELECT p.tipo FROM paginas p INNER JOIN modulos m ON(p.tipo=m.id) WHERE m.repete_pagina!=1)
                                        ORDER BY modu.indice";//11 = PAGINAS - 5=CAPA DO SITE					

}//AND (modu.pag_tab_id!=0 OR modu.id=5)


$tipos = query($sql);
$atributos_itens = getAtributosItens(11); //11 páginas

?>

<script type="text/javascript" src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<form action="_gravar/paginas.php" enctype="multipart/form-data" method="post" id="form">
  <input type="hidden" id="tabela" name="tabela" value="paginas">
  <input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>">
  <input type="file" name="fileupload" id="fileupload" style="display: none;" />
  <table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <h1> Incluir
          <?php
          echo $paginas['titulo'];
          ?>
        </h1>
      </td>
    </tr>

    <tr>
      <td height="15" colspan="2" align="center"></td>
    </tr>
    <tr>
      <td class="titulo_noticias">
        <div class="titulo_noticias" style='float:left; width: 120px;'>Tipo de Conte&uacute;do </div>
        <select name="tipo" id="tipo">
          <?php
          foreach ($tipos as $tipo) {
            echo '<option value="' . $tipo['id'] . '">' . $tipo['titulo'] . '</option>';
          }
          ?>
        </select>
      </td>
    </tr>
    <?php
    //########### VERIFICA O STATUS DO ATRIBUTO ###################
    $ok = getStatusAtributo($atributos_itens, 'titulo');
    if ($ok != false) {
      ?>
      <tr>
        <td colspan="2" class="titulo_noticias">
          <table>
            <th colspan="<?php echo (count($idiomas) * 2); ?>" style="text-align: center;">
              <p style="background-color:#C5CEFA;">
                <?php echo $ok; ?>
              </p>
            </th>
            <tr>
              <?php $total_criado = 0;
              foreach ($idiomas as $idioma) {
                if ($total_criado == 2) {
                  echo '</tr><tr>';
                  $total_criado = 0;
                }
                echo '<td class="titulo_noticias" style="font-weight: normal;">' . $idioma['nome'] . '</td>
                                        <td class="titulo_noticias"><label>
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
    <?php }

    /** OCULTA LISTA DE SUB-PAGINAS
     *	ARI em 09/12/2011
     *	para liberar apagar essas linhas (97-98-99) e 142
     **/



    //########### VERIFICA O STATUS DO ATRIBUTO ###################
    $ok = getStatusAtributo($atributos_itens, 'sub_pagina');
    if ($ok != false) {
      ?>
      <tr>
        <td class="titulo_noticias">
          <div class="titulo_noticias" style='float:left; width: 120px;'>
            <?php echo $ok; ?>
          </div>
          <select name="pai" id="pai">
            <option value="0">-- Nenhuma --</option>
            <?php

            $sql = "SELECT p.id,p.titulo,p.status,p.posicao
                        FROM paginas p
                        RIGHT JOIN pag_subpag_nivel csn ON (p.id = csn.pag_pai_id)
                        WHERE csn.pag_filho_id IS NULL 
                        AND csn.pag_neto_id IS NULL   
                        -- AND p.id = 1                     
                        ORDER BY p.posicao";
            $paginas_pai = query($sql);

            

            foreach ($paginas_pai as $r) {
              echo "<option value=" . $r['id'] . ">" . $r['titulo'] . "</option>";
              //BUSCA FILHOS
              $sql = "SELECT c.id, csn.pag_filho_id, c.titulo, c.status
                                   FROM paginas c
                                   LEFT JOIN pag_subpag_nivel csn ON (c.id=csn.pag_filho_id)
                                   WHERE csn.pag_pai_id='" . $r['id'] . "'
                                   AND csn.pag_neto_id IS NULL
                                   ORDER BY c.posicao ASC";
              $pagFilho_array = query($sql);
              foreach ($pagFilho_array as $f) {
                echo "<option value=".$r['id'].'-'.$f['id'].">-- ".$f['titulo']."</option>";
              }
            }
            ?>
          </select>
        </td>
      </tr>
    <?php }

    //########### VERIFICA O STATUS DO ATRIBUTO ###################
    $ok = getStatusAtributo($atributos_itens, 'imagem');
    if ($ok != false) {
      ?>
      <tr>
        <td class="titulo_noticias">
          <div class="titulo_noticias" style='float:left; width: 120px;'>
            <?php echo $ok; ?>
          </div>
          <input name="imagem" type="file" id="imagem" size="43">
          <!-- Tamanho Imagem Pequena (Thumb) -->
        </td>
      </tr>
      <tr>
        <td colspan="2" class="titulo_noticias">
          <hr style="width: 100%" />
        </td>
      </tr>
    <?php }

    //########### VERIFICA O STATUS DO ATRIBUTO ###################
    $ok = getStatusAtributo($atributos_itens, 'title');
    if ($ok != false) {
      ?>

      <tr>
        <td colspan="2" class="titulo_noticias" align="center">
          <div
            style="background:#00579E; width:auto; height:auto; padding:10px 0; margin:20px 0; color:#FFF; line-height:30px;">
            Dicas para um bom posicionamento do seu site nos sites de busca: <a
              href="http://artwebdigital.com.br/wiki/dicas-seo/dicas-seo.pdf"
              style="background:#FFF; width:200px; height:30px; text-align:center; line-height:30px; display:block; margin-top:10px;"
              target="_blank">Dicas de Otimização</a>
          </div>
        </td>
      </tr>

      <tr>
        <td colspan="2" class="titulo_noticias">
          <div style="background-color:#C5CEFA; width: 100%; text-align: center;">
            <?php echo $ok; ?>
          </div>
          <table>
            <tr>
              <?php $total_criado = 0;
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
    <?php }
    //########### VERIFICA O STATUS DO ATRIBUTO ###################
    $ok = getStatusAtributo($atributos_itens, 'metad');
    if ($ok != false) {
      ?>
      <tr>
        <td colspan="2" class="titulo_noticias">
          <div style="background-color:#C5CEFA; width: 100%; text-align: center;">
            <?php echo $ok; ?>
          </div>
          <table>
            <tr>
              <?php
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
    <?php }
    //########### VERIFICA O STATUS DO ATRIBUTO ###################
    $ok = getStatusAtributo($atributos_itens, 'conteudo');
    if ($ok != false) {
      ?>
      <tr>
        <td colspan="4" class="titulo_noticias">
          <div style="background-color:#C5CEFA; width: 100%; text-align: center;">
            <?php echo $ok; ?>
          </div>
          <table style="width: 100%;">
            <tr>
              <td>Português</td>
            </tr>
            <tr>
              <td class="titulo_noticias">
                <textarea class="editor" id="textoPort" name="textoPort"></textarea>
              </td>
            </tr>
            <?php
            $total_criado = 1;
            foreach ($idiomas as $idioma) {
              if ($total_criado == 2) {
                echo '</tr><tr>';
                $total_criado = 0;
              }

              if ($idioma['sigla'] != "Port") { ?>
                <tr>
                  <td>
                    <?php echo $idioma['nome']; ?>
                  </td>
                </tr>
                <tr>
                  <td class="titulo_noticias">
                    <textarea class="editor" id="texto<?php echo $idioma['sigla']; ?>"
                      name="texto<?php echo $idioma['sigla']; ?>"></textarea>
                  </td>
                </tr>
              <?php }
              $total_criado++;
            } ?>
          </table>
        </td>
      </tr>
    <?php } ?>
    <tr>
      <td colspan="2" align="right" class="titulo_noticias">
        <input type="submit" value="Incluir" class="botao_form">
      </td>
    </tr>
    <tr>
      <td colspan="2" align="right" class="titulo_noticias"> </td>
    </tr>
  </table>
</form>
<script type="text/javascript">
  new Validation('form');
</script>