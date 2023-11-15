<?php 
	include("../php/sessao.php");
	include("../includes/db.php");
	include ("../php/funcoes.php");
	include("../../php/plugins/seo.php");

	extract($_POST);
	
	$conn = conecta();

	#apaga todos clientes desse album#
	$sql ="DELETE FROM albuns_clientes WHERE albuns_id = ".$id;
	$q = @mysqli_query($conn, $sql);
	
	//foreach ($clientes as $c){
	//	$sql = "INSERT INTO albuns_clientes(albuns_id, clientes_id)VALUES('$id', '$c')";
	//	$q = @mysql_query($sql,$conn);
	//}
	
	$modulo = query("SELECT orientacao, tam_principal, tam_thumb FROM modulos WHERE pag_tab_id='".$pag."';");

$idiomas = query("SELECT * FROM idiomas WHERE status=1");

# Imagem Principal #
$imagemUP = $_FILES['imagem'];
if ($imagemUP['error'] == 0 ){
	$imagem = gravaImagem($imagemUP, $tabela, $modulo['0']['tam_principal'], $modulo['0']['tam_thumb'], $modulo['0']['orientacao']);
	if (!$imagem) {
		$UPimagem = "";
	} else {
		$UPimagem = "imagem='$imagem',";
	}
} else {
    $UPimagem = "";    
}

// Gravando a data
$created = explode('/', $created);
$created = $created[2]."-".$created[1]."-".$created[0]." 00:00:00";

//$titulo = mysql_escape_string($titulo);

$noticia_id=0;
$erro=true;

foreach ($idiomas as $idioma) {
    $idioma_id = $idioma['id'];
    $sigla = $idioma['sigla'];
    $titulo = $_POST['titulo'.$sigla];
    $texto = $_POST['texto'.$sigla];
    //$titulo = mysql_escape_string($titulo);
    //$texto = mysql_escape_string($texto);

    if (strtolower(trim($sigla))=='port') {
            $sql = "UPDATE $tabela SET titulo='$titulo', videos='$videos', tipo='$categoria', conteudo='$texto', created='$created', ".$UPimagem."modified =NOW() WHERE id=$id ";
            $conn = conecta();
            $q = @mysqli_query($conn, $sql);
            if($q == false){
                    $msg = "Erro ao realizar a operação! código 1".  mysqli_error($GLOBALS["___mysqli_ston"]);
                    @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
            }else{
                $msg = "Operação realizada com sucesso!";
            }

		$link = limpaURL($title);
		$verifica = query("SELECT * FROM links WHERE lin_nome = '$link' AND lin_id_pg <> $id");

		//caso exista ja um link igual este, entao será adicionado a data do cadastro no final deste link, a data no formato dd-mm-yyyy !!!SEM AS BARAS!!!
		if(count($verifica) >0 ) {
			$dia = date("d-y-i");
			$link = $link."-".$dia;
		}
		
		$conn = conecta();
		$upLink = "UPDATE links SET title='$title', metad='$metad', lin_nome = '$link' WHERE lin_id_pg = '$id' AND tipo = 5";
		$q2 = @mysqli_query($conn, $upLink);

    }else{
        $sql = "UPDATE albuns_idioma SET titulo='$titulo', conteudo='$texto' WHERE albuns_id=$id AND idioma_id=$idioma_id";
        $conn = conecta();
        $q = @mysqli_query($conn, $sql);
        //SE NÃO EXISTE DADOS DE IDIOMA NA TABELA, CRIAR: (sitemas antes deste código não inserem noticoas de idioma vazio)
        if(mysqli_affected_rows($conn)==0){
            $sql="INSERT INTO albuns_idioma(albuns_id,idioma_id,titulo,conteudo)VALUES('$id','$idioma_id','$titulo','$texto')";
            $q = mysqli_query($conn, $sql);
        }
    }
}

if (!headers_sent($filename, $linenum)) {
	header('Location: ../index.php?pag='.$pag.'&tipo=p&id='.$id.'&msg='.$msg);
    exit;
}	

?>