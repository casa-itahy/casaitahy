<?php 
include_once("../php/sessao.php");
session_write_close();
include_once("../includes/db.php");
include_once("../php/funcoes.php");
include_once("../php/class.upload.php");

extract($_POST);
$pdfs = $_FILES['pdf'];

########## GRAVA PDF ##############
function retira_acentos($frase){
    $frase = preg_replace("[^a-zA-Z0-9_.]", "", strtr($frase, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ","aaaaeeiooouucAAAAEEIOOOUUC_"));
    return $frase;
}

if (is_uploaded_file($pdfs['tmp_name'])) {
//PARA CADA ITEM DE ARQUIVO, VERIFICA SE É UM PDF
    //if (($pdfs['type'] == "application/pdf") || ($pdfs['type'] == "application/x-forcedownload")) {
     $name = date('his').retira_acentos(ucwords(strtolower(utf8_encode($pdfs['name']))));
     //SALVA PDF NO SERVIDOR
     $result = move_uploaded_file($pdfs['tmp_name'],"../docs_upload/$name");
    //}
}

if (empty ($pasta)){
	$pasta = date("dmYhis");
}

//$titulo = mysql_escape_string($titulo);

$imagemUP = $_FILES['imagem'];
if (count($imagemUP) != 0 ){
	if ($imagemUP['error'] == 0 ){
		$tam_img = getimagesize($imagemUP['tmp_name']);
		$destino = "../imagens/docs";
		$num = date("dmYhis");
		$handle = new Upload($imagemUP);
		if ($handle->uploaded){
		#----- Gera Thumb -----#
		if ($tam_img[0] < $largura){
			$handle->image_resize = false;
		}else{
			$handle->image_resize = true;
		}
                    $handle->image_ratio_x = false;
                    $handle->image_ratio_y = true;
                    $handle->image_x = 120;
                    $handle->image_y = 120;
                    $handle->file_new_name_body	= "thumb_".$num;
                    $handle->Process($destino);                    
                    $handle-> Clean();
                    $foto_principal=$handle->file_dst_name;
		}
		$UPimagem = "imagem='$foto_principal',";
	}	
}

if(isset($name)){
    $name = "src='".$name."', ";
}

$idiomas = query("SELECT * FROM idiomas WHERE status=1");

    foreach($idiomas as $idioma){
        $conn = conecta();
        $idioma_id = $idioma['id'];
        $sigla = $idioma['sigla'];
        $titulo_idioma = $_POST['titulo'.$sigla];

        $conn = conecta();
        if(strtolower(trim($sigla))=='port'){                
             $sql = "UPDATE docs SET titulo='".$titulo."', descricao='".$descricao."', ".$name." ".$UPimagem." dt_upload=NOW() WHERE id=$id";
             $q = mysqli_query($conn, $sql);
        }else{
            $sql="UPDATE docs_idioma SET titulo='".$titulo_idioma."' WHERE docs_id=$id AND idioma_id=$idioma_id";
            $q = mysqli_query($conn, $sql);
//            if(mysqli_affected_rows($conn)==0){
//                $sql="INSERT INTO docs_idioma(docs_id,idioma_id,titulo)VALUES('$id','$idioma_id','".$titulo_idioma."')";
//                $q = mysqli_query($conn, $sql);
//            }
        }
    }
if($q == false){
        $msg = "Erro ao realizar a operação! código 1".  mysqli_error($GLOBALS["___mysqli_ston"]);
        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
}else{
       $msg = "Operação realizada com sucesso!"; 
}

if (!headers_sent($filename, $linenum)) {
	header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
    exit;
}	

?>