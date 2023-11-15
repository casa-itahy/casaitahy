<?php 
include_once("../php/sessao.php");
session_write_close();
include_once("../php/Imagens.class.php");

extract($_POST);

$pdfs=$_FILES['arquivo'];
$imagens=$_FILES['imagem'];

function retira_acentos($frase){
    $frase = preg_replace("[^a-zA-Z0-9_.]", "", strtr($frase, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ","aaaaeeiooouucAAAAEEIOOOUUC_"));
    return $frase;
}

@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
$conn = conecta();
for($x=0;$x<=(count($pdfs['tmp_name'])-1);$x++){        
    if (is_uploaded_file($pdfs['tmp_name'][$x])) {          
          //PARA CADA ITEM DE ARQUIVO, VERIFICA SE É UM PDF          
          //if (($pdfs['type'][$x] == "application/pdf") || ($pdfs['type'][$x] == "application/x-forcedownload")) {            
             $name = date('his').retira_acentos(ucwords(strtolower(utf8_encode($pdfs['name'][$x]))));
             //SALVA PDF NO SERVIDOR
             $result = move_uploaded_file($pdfs['tmp_name'][$x],"../docs_upload/$name");             
             if($result){
                 //SALVA IMAGEM NO SERVIDOR
                 // $imagem = new Imagens('docs', $imagens);
                 // $salvou = $imagem->salvaImgPorIndice($x);
                 // if($salvou==false){                 
                 //     $salvou=' ';
                 // }
                 $idiomas = query("SELECT * FROM idiomas WHERE status=1");                
                 $item_id=0;
                 $erro=true;
                 foreach($idiomas as $idioma){
                    $idioma_id = $idioma['id'];
                    $sigla = $idioma['sigla'];
                    $titulo = $_POST['legenda'.$sigla];                    
                    $conn = conecta();
                    if(strtolower(trim($sigla))=='port'){
                                $sql="INSERT INTO docs (src,titulo,descricao,tipo,dt_upload)VALUES('$name','".$titulo[$x]."','".$descricao[$x]."','1',NOW());";
                                $q = mysqli_query($conn, $sql);
                                $item_id = ((is_null($___mysqli_res = mysqli_insert_id($conn))) ? false : $___mysqli_res);                                
                    }else{
                        if($item_id!=0){
                            $sql="INSERT INTO docs_idioma(docs_id,idioma_id,titulo)VALUES('$item_id','$idioma_id','$titulo[$x]')";
                            $q = mysqli_query($conn, $sql);
                            //var_dump($sql);
                            //die();
                        }
                    }
                 }
                 //SALVA OS DADOS NO BANCO
                 if($q==false){
                     $msg="Não foi possível inserir os dados".$sql;
                 }else{
                     $msg="Dados inseridos com sucesso!";                 
                 }
             }else $msg='Não foi possível inserir o PDF';
          //}
        //}
        //die();
    }
}


if (!headers_sent($filename, $linenum)) {
    header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
    exit;
}

?>