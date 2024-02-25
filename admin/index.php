<?php
include_once("includes/db.php");
if (isset($_GET['pag'])) {
    $pag = $_GET["pag"];
    $tipo = $_GET["tipo"];//p = pagina , a=_add , e = _editar
} else {
    $pag = '';
}
if (!isset($_GET['msg'])) {
    $_GET['msg'] = '';
}
$achou = '';
$css = '';

@session_start();

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta HTTP-EQUIV="Pragma" CONTENT="no-cache" />
    <meta HTTP-EQUIV="Expires" CONTENT="-1" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Admin - Artweb Design Digital</title>
    <link href="css/default.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/menu.css" type="text/css">

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.2.min.js"></script>

    <!-- Javascript Menu -->
    <script type="text/javascript" src="js/custom_lib.js"></script>
    <script type="text/javascript" src="js/prototype.js"></script>
    <script type="text/javascript" src="js/jquery.corner.js"></script>
    <script type="text/javascript" src="tinymce/tinymce.min.js"></script>

    <script type="text/javascript" src="js/mascara.js"></script>

    <script type="text/javascript">
        jQuery(function ($) {
            tinymce.init({
                selector: "textarea.editor",
                theme: "modern",
                file_picker_callback: function (callback, value, meta) {
                    // File type
                    if (meta.filetype == "media" || meta.filetype == "image") {

                        // Trigger click on file element
                        $("#fileupload").trigger("click");
                        $("#fileupload").unbind('change');

                        // File selection
                        $("#fileupload").on("change", function () {
                            var file = this.files[0];
                            var reader = new FileReader();

                            // FormData
                            var fd = new FormData();
                            var files = file;
                            fd.append("file", files);
                            fd.append('filetype', meta.filetype);

                            var filename = "";

                            // AJAX
                            $.ajax({
                                url: "upload-editor.php",
                                type: "post",
                                data: fd,
                                contentType: false,
                                processData: false,
                                async: false,
                                success: function (response) {
                                    filename = response;
                                }
                            });

                            reader.onload = function (e) {
                                callback("imagens/editor/" + filename);
                            };
                            reader.readAsDataURL(file);
                        });
                    }

                },

                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor"
                ],
                height: 300,
                toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons"
            });

            $("#dataEx").mask("99/99/9999");

            $("#statusAtualiza").corner(function () {
                $(this).corner("10px");
            });

            $('#senhaExpira').click(function () {
                $('#LiberadOo').show();
            })
            $('#senhaNaoExpira').click(function () {
                $('#LiberadOo').hide();
            })

            $('#senhaNaoExpira').click(function () {
                $('#agoraVai').hide();
            })

            $('#senhaExpira').click(function () {
                $('#agoraVai').show();
            })

            $("#gallery").dragsort({ dragSelector: "div", dragEnd: saveOrder, placeHolderTemplate: "<li class='placeHolder'><div></div></li>" });

            function saveOrder() {
                var data = $("#gallery li, #gallery_2 li").map(function () { return $(this).attr("itemID"); }).get();
                $.post("php/ordena_img_prod.php", { "ids[]": data });
            };

            $("#gallery_2").dragsort({ dragSelector: "div", dragEnd: saveOrder, placeHolderTemplate: "<li class='placeHolder'><div></div></li>" });

            // function saveOrder() {
            //   var data = $("#gallery_2 li").map(function() { return $(this).attr("itemID"); }).get();
            //       $.post("php/ordena_img_prod.php", { "ids[]": data });
            //   };
        });		
    </script>
</head>

<body>
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height="206" background="img/bg_cabecalho.jpg">&nbsp;</td>
            <td background="img/bg_cabecalho.jpg">&nbsp;</td>
            <td width="767" align="center" valign="bottom" background="img/bg_cabecalho.jpg">
                <a href="index.php"><img src="http://www.artwebdigital.com/_imagens/cabecalho.jpg" border="0"></a>
            </td>
            <td background="img/bg_cabecalho.jpg">&nbsp;</td>
            <td background="img/bg_cabecalho.jpg">&nbsp;</td>
        </tr>
        <tr>
            <?php if (isset($_SESSION['nome_adm'])) { ?>
                <td height="39" colspan="5" align="center" background="img/bg_menu.jpg" class="menu_superior">

                    <!-- ################ CRIA MENU PRINCIPAL ############## -->

                    <div id="menu">
                        <div class="moduletable_topmenu">
                            <ul class="menu">
                                <?php
                                $pula_menu_principal = array();
                                $aberto_ul = array();
                                $menu_li = array();
                                $modulos = $_SESSION['pages'];
                                @session_write_close();
                                if (count($modulos) < 1) {
                                    echo "<span style='color:#FFFFFF; valign:bottom;'>NÃO EXISTE PERMISSÃO DE MENU PARA ESTE USUÁRIO. <br /> Para inserir permissões, faça login como administrador e entre no menu Usuario->Editar.</span>";
                                    echo '<a style="color:#red;" href="php/sair.php"><span> - Sair - </span></a>';
                                    die();
                                } else {
                                    foreach ($modulos as $k => $pg) {
                                        //VERIFICA SE EXISTE UM ID PAI(ENTAO É SUBMENU)
                                        if ($pg['id_pai_submenu']) {
                                            //SE SIM
                                            //VERIFICA SE JA FOI ABERTO O LI PAI PARA COLOCAR OS SUBMENUS(UL)
                                            if (in_array($pg['id_pai_submenu'], $aberto_ul) === false) {
                                                if ($menu_li[$pg['id_pai_submenu']]) {//SE EXISTE UM MENU PAI
                                                    //SE NÃO, INSERE A ABERTURA DO SUBMENU
                                                    $menu_li[$pg['id_pai_submenu']] .= '<ul>';
                                                    //CRIA O SUBMENU DO LI PRINCIPAL
                                                    $menu_li[$pg['id_pai_submenu']] .= '
                                                            <li class="item' . $modulos[$pg['id_pai_submenu']]['pag_tab_id'] . '">
                                                                <a href="index.php?pag=' . $modulos[$pg['id_pai_submenu']]['pag_tab_id'] . '&tipo=p">
                                                                   <span>Cadastro ' . $modulos[$pg['id_pai_submenu']]['titulo'] . '</span>
                                                                </a>
                                                            </li>';
                                                } else {
                                                    //SE EXISTE UM SUBMENU PORÉM NÃO TEM AINDA NO LI MENU PRINCIPAL                                                
                                                    $menu_li[$pg['id_pai_submenu']] = '
                                                            <li class="item' . $modulos[$pg['id_pai_submenu']]['pag_tab_id'] . '">
                                                                <a href="#">
                                                                   <span>Cadastro ' . $modulos[$pg['id_pai_submenu']]['titulo'] . '</span>
                                                                </a>
                                                            <ul>';
                                                    $pula_menu_principal[$pg['id_pai_submenu']] = $pg['id_pai_submenu'];
                                                    $aberto_ul[] = $pg['id_pai_submenu'];
                                                }
                                            }
                                            //CRIA O LI DO SUBMENU dentro do li pai
                                            $menu_li[$pg['id_pai_submenu']] .= '
                                                        <li class="item' . $k . '">
                                                            <a href="index.php?pag=' . $k . '&tipo=p">
                                                               <span>' . $pg['titulo'] . '</span>
                                                            </a>
                                                        </li>';
                                            $aberto_ul[] = $pg['id_pai_submenu'];

                                        } else {
                                            //SE NÃO, CRIA UMA LI PAI SIMPLES                                      
                                            if (!in_array($k, $pula_menu_principal)) {
                                                $menu_li[$k] = '
                                                    <li class="parent item2">
                                                        <a href="index.php?pag=' . $k . '&tipo=p">
                                                            <span>' . $pg['titulo'] . '</span>
                                                        </a>';

                                            }
                                        }
                                    }
                                    //FECHA OS MENUS UL (PAI)
                                    foreach ($aberto_ul as $item) {
                                        $menu_li[$item] .= '</ul>';
                                    }
                                    //FECHA TODOS OS LI PAI
                                    foreach ($menu_li as $menu) {
                                        echo $menu .= '</li>';
                                    }
                                }

                                ?>
                                <li class="parent item2">
                                    <a href="php/sair.php"><span>Sair</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- FIM MENU -->

                </td>
            <?php
            } else {
                @session_write_close();
                $pag = "login";
                ?>
                <td height="39" colspan="5" align="center" background="img/bg_menu.jpg" class="menu_superior">
                <?php } ?>
        </tr>

        <tr>
            <td class="bg_home">&nbsp;</td>
            <td width="50" class="bg_sombra">&nbsp;</td>
            <td align="center" valign="top">
                <div style="min-height:400px;">


                    <?php

                    if ($pag == "home") {
                        $achou = true;
                        include("pag/home.php");
                    } else {
                        if ($pag == "login") {
                            $achou = true;
                            echo "<script>window.location.href='pag/login.php'</script>";
                            exit;
                        } else {
                            
                            foreach ($_SESSION['pages'] as $key => $paginas) {
                                
                                if ($pag == $paginas['pag_tab_id']) {
                                    $_SESSION['pag_id_atual'] = $paginas['pag_tab_id'];
                                    @session_write_close();
                                    if ($tipo == 'p')
                                        include("pag/" . $paginas['pag_tab_nome'] . ".php");
                                    else
                                    if ($tipo == 'a')
                                        include("_add/" . $paginas['pag_tab_nome'] . ".php");
                                    if ($tipo == 'e')
                                        include("_editar/" . $paginas['pag_tab_nome'] . ".php");
                                    if ($tipo == 'pass')
                                        include("_editar/usuariosPass.php");

                                    $achou = true;
                                    break;
                                }
                            }
                            if ($achou == false) {
                                if ($pag == 'blocos') {
                                    if ($tipo == 'p')
                                        include_once("pag/blocos.php");
                                    if ($tipo == 'a')
                                        include_once("_add/blocos.php");
                                    if ($tipo == 'e')
                                        include_once("_editar/blocos.php");
                                } else {
                                    if ($pag == 'especifica') {
                                        if ($tipo == 'p')
                                            include_once("pag/especifica.php");
                                        if ($tipo == 'a')
                                            include_once("_add/especifica.php");
                                        if ($tipo == 'e')
                                            include_once("_editar/especifica.php");
                                    } else {
                                        include("pag/home.php");
                                    }
                                }
                            }
                        }
                    }
                    ?>
                </div>
            </td>
            <td width="50" class="bg_sombra_direita">&nbsp;</td>
            <td class="bg_home">&nbsp;</td>
        </tr>
        <tr>
            <td height="48" colspan="5" align="center" background="img/bg_inf.jpg" class="texto_artweb">
                &copy;
                <?php echo date('Y'); ?> - Todos os direitos reservados.
                <a href="http://www.artwebdigital.com.br">Artweb Design Digital.</a>
            </td>
        </tr>
    </table>
</body>

</html>