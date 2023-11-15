<?php 
include("../php/funcoes.php");
include("../includes/db.php");

$album_id = $_POST['id'];
$txt_legenda = $_POST['valor'];

if(trim($txt_legenda)!='Adicionar legenda'){
    $sql = "UPDATE img_pasta_albuns SET legenda='".$txt_legenda."' WHERE id=$album_id";
    $conn = conecta();
    $q = @mysqli_query($conn, $sql);

    if($q == false){
        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);                        
    }
}

echo 'ok';

?>