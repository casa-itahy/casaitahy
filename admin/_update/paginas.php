<?php
include("../includes/db.php");
include("../php/funcoes.php");
include("../php/imgCaminho.php");
include("../../php/plugins/seo.php");

extract($_POST);

$idiomas = query("SELECT * FROM idiomas WHERE status=1");
$modulo = query("SELECT orientacao, tam_principal, tam_thumb FROM modulos WHERE pag_tab_id='$pag'");

$UPimagem = '';
$UPimagem2 = '';
$subtitulo = ''; // Definindo $subtitulo com valor padrão
$oldid = $id; // Definindo $oldid com valor padrão

$imagemUP = isset($_FILES['imagem']) ? $_FILES['imagem'] : null;
if (!empty($imagemUP['name']) && $imagemUP['error'] == 0) {
    $imagem = gravaImagem($imagemUP, $tabela, $modulo[0]['tam_principal'], $modulo[0]['tam_thumb'], $modulo[0]['orientacao']);
    if ($imagem) {
        $UPimagem = "imagem='$imagem', ";
    }
}

$imagemUP2 = isset($_FILES['imagem2']) ? $_FILES['imagem2'] : null;
if (!empty($imagemUP2['name']) && $imagemUP2['error'] == 0) {
    $imagem2 = gravaImagem($imagemUP2, $tabela . "/imagem2", $modulo[0]['tam_principal'], $modulo[0]['tam_thumb'], $modulo[0]['orientacao']);
    if ($imagem2) {
        $UPimagem2 = "menu_img='$imagem2', ";
    }
}

foreach ($idiomas as $idioma) {
    $idioma_id = $idioma['id'];
    $sigla = $idioma['sigla'];
    $titulo = addslashes($_POST['titulo' . $sigla]);
    $texto = $_POST['texto' . $sigla];
    $title = addslashes($_POST['title' . $sigla]);
    $metad = addslashes($_POST['metad' . $sigla]);

    if (strtolower(trim($sigla)) == 'port') {
        $conn = conecta();
        $sql1 = "UPDATE paginas SET titulo='$titulo', subtitulo='$subtitulo', conteudo='$texto', title='$title', metad='$metad', $UPimagem $UPimagem2 tipo='$tipo', modified=NOW() WHERE id=$oldid ";
		
        $q = mysqli_query($conn, $sql1);

        $tipoPag = query("SELECT * FROM paginas WHERE id=$oldid");
        $tipoPag = $tipoPag[0]['tipo'];

        $nomePg = query("SELECT * FROM modulos WHERE id='$tipoPag'");
        $nmPagina = $nomePg[0]['pag_tab_nome'];

        $upLink = "UPDATE links SET lin_pagina='$nmPagina', title='$title', lin_nome='$link', metad='$metad' WHERE lin_id_pg='$oldid' AND tipo <= 2";
        $q2 = mysqli_query($conn, $upLink);
    } else {
        $conn = conecta();

        $sql = "UPDATE conteudo_simples_idioma SET titulo='$titulo', conteudo='$texto', title='$title', metad='$metad' WHERE pagina_id=$oldid AND idioma_id=$idioma_id";
        $q = mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn) == 0) {
            $sql = "INSERT INTO conteudo_simples_idioma(pagina_id, idioma_id, titulo, title, metad, conteudo) VALUES ('$id', '$idioma_id', '$titulo', '$title', '$metad', '$texto')";
            $p = mysqli_query($conn, $sql);
        }
    }
}

// if ($q != false) {
//     if ($filho == 'NULL' || empty($filho)) {
//         if ($pag != 0) {
//             if ($id_pagina == '') $id_pagina = $oldpai;
//             $sql2 = "UPDATE pag_subpag_nivel SET pag_pai_id=$pag, pag_filho_id=$id_pagina, pag_neto_id=NULL WHERE pag_pai_id='$oldpai' AND $oldfilho " . $oldneto;
//         } else {
//             if ($id_pagina == '') $id_pagina = $oldid;
//             $sql2 = "UPDATE pag_subpag_nivel SET pag_pai_id='$id_pagina', pag_filho_id=NULL, pag_neto_id=NULL WHERE pag_pai_id='$oldpai' AND $oldfilho " . $oldneto;
//         }
//     } else {
//         if ($oldneto != 'NULL') {
//             $neto = $oldneto;
//         }

//         $sql2 = "UPDATE pag_subpag_nivel SET pag_pai_id='$pai', pag_filho_id='$filho', pag_neto_id='$oldid' WHERE pag_pai_id='$oldpai' AND $oldfilho " . $oldneto;
//     }
// 	echo "<p>";
// 	print_r($sql2) ;
// 	echo "</p>";
//     $q = mysqli_query($conn, $sql2);
// }
mysqli_close($conn);

if ($q == '' || $q == true) {
    $msg = "<p>Categoria alterada!</p>";
} else {
    $msg = "<p>Não foi possível alterar os dados</p><p>Caso o problema persista, por favor, informe ao administrador.</p>" . $q;
}

if ($q == '' || $q == true) {
    $volta_altera = '&tipo=p';
    $msg = "Operação realizada com sucesso!";
} else {
    $volta_altera = '&tipo=e&id=' . $id;
    $msg = "Erro ao realizar a operação!";
}

if (!headers_sent($filename, $linenum)) {
    header('Location: ../index.php?pag=1' . $volta_altera . '&msg=' . $msg . '&debug='.$link);
    exit;
}
?>
