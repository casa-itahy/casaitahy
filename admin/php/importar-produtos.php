<?php 

    set_time_limit(5000);

    header ('Content-type: text/html; charset=UTF-8');

    extract($_POST);

    include_once("../includes/db.php");
    include_once ("funcoes.php");
    include("../../php/plugins/seo.php");

    $contaProdutos = 0;

    $arquivo = fopen($_FILES['file_upload']['tmp_name'], 'r');

    while(!feof($arquivo)) {
        // Pega os dados da linha
        $linha = fgets($arquivo, 1024);

        // Divide as Informações das celular para poder salvar
        $dados = explode(';', $linha);

        // Verifica se o Dados Não é o cabeçalho ou não esta em branco
        if($dados[0] != 'CodItem' && $dados[1] != "") {
            $dados[0] = trim($dados[0]);
            $dados[1] = trim($dados[1]);
            $dados[2] = trim($dados[2]);
            if ($dados[2] == 'R$'  OR $dados[2] == 'R$ -') {
                $dados[2] = '';
            }
            $dados[3] = trim($dados[3]);
            if ($dados[3] == 'R$'  OR $dados[3] == 'R$ -') {
                $dados[3] = '';
            }
            $produto = query("SELECT id FROM produtos WHERE cod = '".$dados[0]."'");
            if (empty($produto)) {
                /* Procura a ultima posição */
                $posicao = ultimaPosicao("produtos");
                $posicao = $posicao + 1;

            	$conn = conecta();
            	$sql="INSERT INTO produtos(
                                cod,titulo,categoria_id,valor,valor2,posicao,created,modified
                            )VALUES(
                                '".$dados[0]."','".$dados[1]."','".$categoria."','".$dados[2]."','".$dados[3]."','$posicao',NOW(),NOW())";

                $q = mysqli_query($conn, $sql);

                $contaProdutos++;
            } else {
                $conn = conecta();
                $sql = "UPDATE produtos SET valor = '".$dados[2]."', valor2 = '".$dados[3]."', modified =NOW() WHERE id = ".$produto[0]['id'];
                $q = mysqli_query($conn, $sql);

                $contaProdutos++;
            }
        }
    }

    $msg = $contaProdutos." especialidades foram cadastradas/editadas!";

    if (!headers_sent($filename, $linenum)) {
        header('Location: ../index.php?pag=3&tipo=p&msg='.$msg);
        exit;
    }