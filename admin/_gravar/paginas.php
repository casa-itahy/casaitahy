<?php
include("../includes/db.php");
include("../includes/MySQLDB.php");
include("../php/funcoes.php");
include("../php/imgCaminho.php");
include("../../php/plugins/seo.php");

extract($_POST);
echo "<pre>";
print_r($_POST);
echo "</pre>";

$modulo = query("SELECT orientacao, tam_principal, tam_thumb FROM modulos WHERE pag_tab_id='" . $pag . "';");

$descricaoSite = query("SELECT descricao FROM config WHERE id = 1");

$idiomas = query("SELECT * FROM idiomas WHERE status=1");

/* Procura a ultima posi��o */

$posicao = ultimaPosicao($tabela);
$posicao = $posicao + 1;

/* Envia a imagem para redimensionamento */
$imagemUP = isset($_FILES['imagem']) ? $_FILES['imagem'] : "NULL";
if (!empty($imagemUP['name']) && $imagemUP['error'] == 0) {
    $imagem = gravaImagem($imagemUP, $tabela, $modulo['0']['tam_principal'], $modulo[0]['tam_thumb'], $modulo[0]['orientacao']);
    if (!$imagem) {
        $imagem = '';
    }
}else{
    $imagem = 'NULL';
}


$valores = explode('-', $pai);



if (isset($valores[1])) {
    $pai = $valores[0];
    $filho = $valores[1];
    $tipoLink = 2;
} else {
    $filho = 'NULL';
    $tipoLink = 1;
}
//$mysqli = conectaMysqli();
//AUTOTRANSATION
//$mysqli->autocommit(FALSE);
//$all_query_ok=true; // our control variable
$pagina_id = 0;
$erro = true;
foreach ($idiomas as $idioma) {
    $idioma_id = $idioma['id'];
    $sigla = $idioma['sigla'];
    $titulo = addslashes($_POST['titulo' . $sigla]);
    $texto = $_POST['texto' . $sigla];
    $title = addslashes($_POST['title' . $sigla]);
    $metad = addslashes($_POST['metad' . $sigla]);

    if (strlen($metad) < 20) {
        $metad = $metad . " - " . $descricaoSite[0]['descricao'];
    }

    //pegar caminho das imagens no editor

    $newTexto = pegaImg($texto);

    //echo $newTexto;

    //echo $base;

    //exit();

    //verrificar se o link não ira ser duplicado
    $link = limpaURL($title);
    $verifica = query("SELECT * FROM links WHERE lin_nome = '$link'");

    //caso exista ja um link igual este, entao será adicionado a data (dia e hora) do cadastro no final deste link
    if (count($verifica) > 0) {
        $dia = date("d-h-i");
        $link = $link . "-" . $dia;
    }

    if (strtolower(trim($sigla)) == 'port') {
        $consulta = new MySQLDB();

        if ($filho == 'NULL') {
            $sql1 = "INSERT INTO $tabela (titulo, conteudo, posicao, title, metad, imagem, tipo, created, modified)
                        VALUES('$titulo', '$newTexto', '$posicao', '$title', '$metad', '$imagem', '$tipo', NOW(), NOW())";

            $sql2 = "SELECT @A:=MAX(id) FROM $tabela";
            
            if ($pai == 0) {
                $sql3 = "INSERT INTO pag_subpag_nivel(pag_pai_id) VALUES(@A)";
            } else {
                $sql3 = "INSERT INTO pag_subpag_nivel(pag_pai_id,pag_filho_id) VALUES('$pai',@A)";
            }
            $q = array(
                array("query" => $sql1),
                array("query" => $sql2),
                array("query" => $sql3),
            );
        } else {
            $sql1 = "INSERT INTO $tabela (titulo, conteudo, posicao, title, metad, imagem, tipo, created, modified)
                        VALUES('$titulo', '$newTexto', '$posicao', '$title', '$metad', '$imagem', '$tipo', NOW(), NOW())";

            $sql2 = "SELECT @A:=MAX(id) FROM $tabela";
            $sql3 = "INSERT INTO pag_subpag_nivel(pag_pai_id,pag_filho_id, pag_neto_id) VALUES($pai, $filho, @A)";
            $q = array(
                array("query" => $sql1),
                array("query" => $sql2),
                array("query" => $sql3),
            );
        }
        $all_query_ok = $consulta->transaction($q);
        if ($all_query_ok) {
            $msg = "<p>Os dados foram salvos!</p>";
            $pagina_id = query("SELECT MAX(id) as id FROM $tabela");
            $pagina_id = $pagina_id[0]['id'];


            //GRAVANDO LINK NA TABELA LINKS
            //pegando a pagina
            $nomePg = query("SELECT * FROM modulos WHERE id='" . $tipo . "';");

            $nmPagina = $nomePg[0]['pag_tab_nome'];
            //link url
            $gravaLink = "INSERT INTO links (lin_pagina, lin_nome, title, metad, lin_id_pg, tipo) VALUES ('$nmPagina', '$link', '$title', '$metad', '$pagina_id', '$tipoLink')";
            gravar($gravaLink);

        } else {
            $erro = "<p>Ocorreu um problema durante a gravação no banco de dados.</p><p>Caso continue o problema, comunique seu administrador.</p>";
        }
    } else {
        if ($pagina_id != 0) {
            $sql = "INSERT INTO conteudo_simples_idioma(pagina_id,idioma_id,titulo,title,metad,conteudo)VALUES('$pagina_id','$idioma_id','$titulo','$title','$metad','$newTexto')";
            $conn = conecta();
            $q = mysqli_query($conn, $sql);
            if ($q == false) {
                $erro = $q;
            }
        }
    }

}
if ($erro == false) {
    $msg = "Erro ao realizar a operação!";
} else {
    $msg = "Operação realizada com sucesso!";
}
// Fechar a conexão com o banco de dados
if (!mysqli_close($conn)) {
    // Tratar erro ao fechar conexão
    echo "Erro ao fechar a conexão com o banco de dados.";
    exit;
}

// Redirecionar após fechar a conexão
if (!headers_sent($filename, $linenum)) {
    header('Location: ../index.php?pag=' . $pag . '&tipo=p&msg=' . $msg);
    exit;
}

?>