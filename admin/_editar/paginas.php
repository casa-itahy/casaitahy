<?php
include_once("php/sessao.php");
include_once("includes/functions.php");

$user_id = $_SESSION['id'];
@session_write_close();


$id = $_GET['id'];
$id_old = $id;

$valores = explode('-', $id);

if (isset($valores[1])) {
    $pai = $valores[0];
    $filho = $valores[1];
    if (!empty($valores[2]))
        $id = $valores[2];
    else
        $id = $valores[1];
} else {
    $pai = $valores[0];
    $id = $valores[0];
    $filho = 'NULL';
}

$sql = "SELECT * FROM paginas
            LEFT JOIN pag_subpag_nivel psp ON(paginas.id=psp.pag_pai_id)
            WHERE id=$id ";
$dados = query($sql);

$sql = "SELECT * FROM idiomas WHERE status=1 AND sigla!='Port'";
$idiomas = query($sql);

/*$sql = "SELECT csi.*,i.nome, i.sigla FROM paginas p 
            LEFT JOIN conteudo_simples_idioma csi ON (p.id=csi.pagina_id)
            LEFT JOIN idiomas i ON(csi.idioma_id=i.id)
        WHERE p.id=$id ORDER BY i.id";*/

$sql = "(SELECT i.nome, i.sigla, csi.pagina_id,csi.titulo,csi.title,csi.metad,csi.conteudo
            FROM idiomas i 
                LEFT OUTER JOIN conteudo_simples_idioma csi ON(i.id=csi.idioma_id)
            WHERE i.status=1 AND csi.pagina_id=$id AND i.status=1
            ORDER BY i.id)
            UNION ALL
            (SELECT i.nome, i.sigla, null,null,null,null,null
            FROM idiomas i 
            WHERE i.status=1 AND i.id!=1
               AND id NOT IN (SELECT idioma_id FROM conteudo_simples_idioma WHERE pagina_id=$id)
            ORDER BY i.id)";

//echo $sql; die();

$dados_idioma = query($sql);


if ($user_id == 1) {
    $sql = "SELECT id, titulo, indice,pag_tab_id FROM
            modulos WHERE status=1 AND status_conteudo_simples=1    
            AND id NOT IN (SELECT p.tipo FROM paginas p INNER JOIN modulos m ON(p.tipo=m.id) WHERE m.repete_pagina!=1 AND m.id!=" . $dados[0]['tipo'] . ")
            ORDER BY titulo";//AND id NOT IN (SELECT p.tipo FROM paginas p)
} else {
    $sql = "SELECT modu.id, modu.titulo, modu.indice, modu.pag_tab_id 
                FROM usuarios_modulos um
                LEFT JOIN modulos modu ON (um.modulo_id = modu.id)
                WHERE um.usuario_id='" . $user_id . "' 
                    AND modu.status=1 
                    AND modu.status_conteudo_simples=1
                    AND id NOT IN (SELECT p.tipo FROM paginas p INNER JOIN modulos m ON(p.tipo=m.id) WHERE m.repete_pagina!=1 AND m.id!=" . $dados[0]['tipo'] . ")
                ORDER BY modu.indice";//11 = PAGINAS - 5=CAPA DO SITE
}

$tipos = query($sql);


$sql = "SELECT id,pag_tab_nome FROM modulos WHERE id=11";

$nivel = query($sql);

$atributos_itens = getAtributosItens(11);

$titulo = htmlspecialchars($dados[0]['titulo']);

?>
<script type="text/javascript" src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />



<form action="_update/paginas.php" enctype="multipart/form-data" method="post" id="form">
    <input type="hidden" id="tabela" name="tabela" value="paginas">
    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
    <input type="hidden" id="pag" name="pag" value="1">
    <input type="file" name="fileupload" id="fileupload" style="display: none;" />

    <table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" height="15" align="center">
                <p class="msg">
                    <?php echo $_GET['msg']; ?>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <h1>Editar
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
                <div class="titulo_noticias" style="float: left; width: 140px;">Tipo de Conte&uacute;do</div>
                <select name="tipo" id="tipo" class="validate-selection">
                    <option value="0">-- Escolha --</option>
                    <?php
                    foreach ($tipos as $tipo) {
                        echo '<option value="' . $tipo['id'] . '" ';
                        if ($tipo['id'] == $dados[0]['tipo']) {
                            echo 'selected="selected" ';
                        }
                        echo '>' . $tipo['titulo'] . '</option>';
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
                    <div style="background-color:#C5CEFA; width: 100%; text-align: center;">
                        <?php echo $ok; ?>
                    </div>
                    <table>
                        <tr>

                            <?php echo '<td class="titulo_noticias" style="font-weight: normal; ">Português</td>
                            <td class="titulo_noticias"><label>
                                <input name="tituloPort" type="text" id="tituloPort" size="55"  class="required" value="' . $titulo . '" />
                            </label></td>';
                            if (count($dados_idioma) > 0) {
                                $total_criado = 1;
                                foreach ($dados_idioma as $idioma) {
                                    $nome = $idioma['nome'];
                                    $sigla = $idioma['sigla'];
                                    $titulo = $idioma['titulo'];

                                    if ($total_criado == 2) {
                                        echo '</tr><tr>';
                                        $total_criado = 0;
                                    }

                                    echo '<td class="titulo_noticias" style="font-weight: normal;">' . $nome . '</td>
                                <td class="titulo_noticias"><label>
                                    <input name="titulo' . $sigla . '" type="text" id="titulo' . $sigla . '" size="55"  class="required" value="' . $titulo . '" />
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
            <?php
        }

        /** OCULTA LISTA DE SUB-PAGINAS
         *	ARI em 09/12/2011
         *	para liberar apagar essas linhas (177-178-179) e 258
         */
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens, 'sub_pagina');
        if ($ok != false) {
           //pr($nivel);
            if ($nivel[0]['pag_tab_nome'] != 'paginas') {
                ?>

                <tr>
                    <td class="titulo_noticias">

                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                        <input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" />
                        <input type="hidden" name="oldpai" id="oldpai" value="<?php echo $id_old; ?>" />

                        <?php

                        $sql = "SELECT * FROM pag_subpag_nivel WHERE pag_pai_id = " . $id . " AND pag_filho_id IS NOT NULL";
                        $temFilho = query($sql);

                        if (count($temFilho) == 0) {
                            $sql = "SELECT * FROM pag_subpag_nivel WHERE pag_filho_id = " . $id . " AND pag_neto_id IS NOT NULL";
                            $temNeto = query($sql);

                            if (count($temNeto) == 0) {
                                ?>

                                <div class="titulo_noticias" style="float: left; width: 140px;">
                                    <?php echo $ok; ?>
                                </div>
                                <select name="pai" id="pai">
                                    <option value="0">-- Nenhuma --</option>
                                    <?php

                                    $sql = "SELECT ps.id,ps.titulo,ps.status,ps.posicao
                                           FROM paginas ps
                                           RIGHT JOIN pag_subpag_nivel psn ON (ps.id = psn.pag_pai_id)
                                           WHERE psn.pag_filho_id IS NULL
                                           AND psn.pag_neto_id IS NULL                        
                                           ORDER BY ps.posicao";
                                    $categorias = query($sql);

                                    $selected = '';
                                    if (count($categorias) > 0) {
                                        foreach ($categorias as $r) {

                                            //Se nao foi a propria
                                            if ($r['id'] != $id) {

                                                //BUSCA FILHOS
                                                $sql = "SELECT p.id, psn.pag_filho_id, p.titulo, p.status
                                                          FROM paginas p
                                                          LEFT JOIN pag_subpag_nivel psn ON (p.id=psn.pag_filho_id)
                                                          WHERE psn.pag_pai_id='" . $r['id'] . "'
                                                          and psn.pag_neto_id IS NULL
                                                          ORDER BY p.posicao ASC";
                                                $catFilho_array = query($sql);

                                                if (count($catFilho_array) > 0) {
                                                    $cat = "<option value='" . $r['id'] . "'>->" . $r['titulo'] . "</option>";
                                                    $subCat = '';
                                                    foreach ($catFilho_array as $f) {
                                                        if ($f['id'] == $id) {
                                                            $cat = "<option selected='selected' value='" . $r['id'] . "'>->" . $r['titulo'] . "</option>";
                                                        } else {
                                                            $sql = "SELECT p.id, psn.pag_filho_id, psn.pag_neto_id, p.titulo, p.status
                                                                   FROM paginas p
                                                                       LEFT JOIN pag_subpag_nivel psn ON (p.id=psn.pag_filho_id)
                                                                   WHERE psn.pag_neto_id='" . $id . "' AND psn.pag_filho_id='" . $f['id'] . "' LIMIT 1";
                                                            $catNeto_array = query($sql);
                                                            //var_dump($sql);die();
                    
                                                            if (count($catNeto_array) > 0) {
                                                                $subCat .= "<option selected='selected' value='" . $r['id'] . '-' . $f['id'] . "'>&nbsp;&nbsp;&nbsp;&nbsp;-->" . $f['titulo'] . "</option>";
                                                            } else {
                                                                $subCat .= "<option value='" . $r['id'] . '-' . $f['id'] . "'>&nbsp;&nbsp;&nbsp;&nbsp;-->" . $f['titulo'] . "</option>";
                                                            }
                                                        }
                                                    }
                                                    echo $cat . $subCat;
                                                } else {
                                                    echo "<option  value='" . $r[id] . "'>->" . $r[titulo] . "</option>";
                                                }
                                            }
                                        }
                                    }


                                    ?>
                                </select>

                                <?php
                            }
                        }

                        ?>

                    </td>
                </tr>
            <?php
            }
        }
        if ($dados[0]['id'] == 6 or $dados[0]['id'] == 3 or $dados[0]['id'] == 2 or $dados[0]['id'] == 4 or $dados[0]['id'] == 5 or $dados[0]['id'] == 23 or $dados[0]['id'] == 24) { ?>
            <tr>
                <td class="titulo_noticias">
                    <div class="titulo_noticias" style="float: left; width: 140px;">Sub Título</div>
                    <input size="55" name="subtitulo" value="<?php echo $dados[0]['subtitulo']; ?>" />
                </td>
            </tr>
        <?php } ?>

        <?php

        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens, 'imagem');
        if ($ok != false) {
            if ($dados[0]['tipo'] == 11 or $id == 7 or $id == 7 or $id == 9 or $id == 15 or $id == 16 or $id == 17 or $id == 24) {
                ?>
                <tr>
                    <td class="titulo_noticias">
                        <div class="titulo_noticias" style="float: left; width: 140px;">
                            <?php echo $ok; ?>
                        </div>
                        <?php
                        $imagem = $dados[0]['imagem'];
                        $caminho = "imagens/paginas/thumb_" . $imagem;
                        if ($imagem != "") {
                            echo "<img src='" . $caminho . "' style='max-width: 200px;'><a href='php/apagarImagem.php?pasta=paginas&pag=" . $paginas['pag_tab_id'] . "&id=" . $id . "'>&nbsp;Apagar</a>";
                        } else {
                            ?>
                            <input name="imagem" type="file" id="imagem" size="43">
                            <!-- Tamanho Imagem Pequena (Thumb) -->
                        <?php } ?>
                    </td>
                </tr>
            <?php }
            if ($id == 15) { ?>
                <tr>
                    <td class="titulo_noticias">
                        <div class="titulo_noticias" style="float: left; width: 140px;">Segunda Imagem</div>
                        <?php
                        $imagem = $dados[0]['menu_img'];
                        $caminho = "imagens/paginas/imagem2/thumb_" . $imagem;
                        if ($imagem != "") {
                            echo "<img src='" . $caminho . "'><a href='php/apagarImagem2.php?pasta=paginas&pag=" . $paginas['pag_tab_id'] . "&id=" . $id . "'>&nbsp;Apagar</a>";
                        } else {
                            ?>
                            <input name="imagem2" type="file" size="43">
                            <!-- Tamanho Imagem Pequena (Thumb) -->

                        <?php } ?>
                    </td>
                </tr>
                <?php
            }
        }

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
                            <?php echo '<td class="titulo_noticias" style="font-weight: normal;">Português</td>
                            <td class="titulo_noticias">
                                <textarea name="titlePort" id="titlePort" cols="38" rows="3">' . $dados[0]['title'] . '</textarea>
                            </td>';
                            if (count($dados_idioma) > 0) {
                                $total_criado = 1;
                                foreach ($dados_idioma as $idioma) {
                                    $nome = $idioma['nome'];
                                    $sigla = $idioma['sigla'];
                                    $titulo = $idioma['title'];

                                    if ($total_criado == 2) {
                                        echo '</tr><tr>';
                                        $total_criado = 0;
                                    }

                                    echo '<td class="titulo_noticias" style="font-weight: normal;">' . $nome . '</td>
                                <td class="titulo_noticias"><label>
                                    <textarea name="title' . $sigla . '" id="title' . $sigla . '" cols="38" rows="3">' . $titulo . '</textarea>
                                </label></td>';
                                    $total_criado++;
                                }
                            } else {
                                echo monta_textarea($idiomas, 'title');
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
        if ($ok != false) {
            ?>
            <tr>
                <td colspan="2" class="titulo_noticias">
                    <div style="background-color:#C5CEFA; width: 100%; text-align: center;">
                        <?php echo $ok; ?>
                    </div>
                    <table>
                        <tr>
                            <?php echo '<td class="titulo_noticias" style="font-weight: normal;">Português</td>
                            <td class="titulo_noticias"><label>
                                <textarea name="metadPort" id="metadPort" cols="38" rows="3">' . $dados[0]['metad'] . '</textarea>                                
                            </label></td>';
                            if (count($dados_idioma) > 0) {
                                $total_criado = 1;
                                foreach ($dados_idioma as $idioma) {
                                    $nome = $idioma['nome'];
                                    $sigla = $idioma['sigla'];
                                    $titulo = $idioma['metad'];

                                    if ($total_criado == 2) {
                                        echo '</tr><tr>';
                                        $total_criado = 0;
                                    }

                                    echo '<td class="titulo_noticias" style="font-weight: normal;">' . $nome . '</td>
                                <td class="titulo_noticias"><label>
                                    <textarea name="metad' . $sigla . '" id="metad' . $sigla . '" cols="38" rows="3">' . $titulo . '</textarea>                                
                                </label></td>';
                                    $total_criado++;
                                }
                            } else {
                                echo monta_textarea($idiomas, 'metad');
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
        $ok = getStatusAtributo($atributos_itens, 'conteudo');
        if ($ok != false) {
            ?>

            <tr>
                <td colspan="2" class="titulo_noticias">
                    <div style="background-color:#C5CEFA; width: 100%; text-align: center;">
                        <?php echo $ok; ?>
                    </div>

                    <table style="width: 100%;">
                        <tr>
                            <td>Português</td>
                        </tr>
                        <tr>
                            <td class="titulo_noticias">

                                <textarea class="editor" name="textoPort"><?php echo $dados['0']['conteudo']; ?></textarea>
                                <br />
                                <hr />

                            </td>
                        </tr>
                        <?php
                        if (count($dados_idioma) > 0) {
                            $total_criado = 1;

                            foreach ($dados_idioma as $idioma) {
                                if ($total_criado == 2) {
                                    echo '</tr><tr>';
                                    $total_criado = 0;
                                }
                                ?>

                                <tr>
                                    <td>
                                        <?php echo $idioma['nome']; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="titulo_noticias">
                                        <textarea class="editor" name="texto<?php echo $idioma['sigla']; ?>">
                                                            <?php echo $idioma['conteudo']; ?>
                                                        </textarea>
                                        <br />
                                        <hr />
                                    </td>
                                </tr>

                                <?php
                                $total_criado++;
                            }
                        } else {
                            $total_criado = 1;
                            foreach ($idiomas as $idioma) {

                                if ($total_criado == 2) {
                                    echo '</tr><tr>';
                                    $total_criado = 0;
                                }
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $idioma['nome']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="titulo_noticias">
                                        <textarea class="editor" name="texto<?php echo $idioma['sigla']; ?>">
                                                                <?php echo $idioma['conteudo']; ?>
                                                            </textarea>
                                        <br />
                                        <hr />
                                    </td>
                                </tr>
                                <?php
                                $total_criado++;
                            }
                        }
                        ?>
                    </table>
                </td>
            </tr>



        <?php } ?>
        <tr>
            <td colspan="2" align="right" class="titulo_noticias">
                <input type="submit" value="Atualizar" class="botao_form">
            </td>
        </tr>
    </table>

    <?php
    function monta_textarea($idiomas, $nome)
    {
        $text_html = '';
        foreach ($idiomas as $item) {
            $text_html .= '<td class="titulo_noticias" style="font-weight: normal;">' . $item['nome'] . '</td>
            <td class="titulo_noticias">
                <textarea name="' . $nome . $item['sigla'] . '" id="' . $nome . $item['sigla'] . '" cols="38" rows="3"></textarea>
            </td>';
        }
        return $text_html;
    }
    function monta_input($idiomas, $nome)
    {
        foreach ($idiomas as $item) {
            echo '<td class="titulo_noticias" style="font-weight: normal;">' . $item['nome'] . '</td>
        <td class="titulo_noticias"><label>
            <input name="' . $nome . $item['sigla'] . '" type="text" id="' . $nome . $item['sigla'] . '" size="55" />
        </label></td>';
        }
    }
    ?>