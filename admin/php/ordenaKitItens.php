<?php 

include_once("sessao.php");
include_once('../includes/db.php');

$prod_id = $_POST['prod_id'];
$bloco_id = $_POST['bloco_id'];
$item_id = $_POST['item_id'];
$ordem = $_POST['ordem'];

$conn = conecta();
$sql = "UPDATE itens_prod_bloco SET ordem='$ordem' WHERE produto_id=$prod_id AND bloco_id=$bloco_id AND itens_id=$item_id";
$q = mysqli_query($conn, $sql);
@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
if($q==true){
    echo "Item Ordenado!$ordem";
}else{
    echo "Não foi possível ordenar o item, selecione o bloco novamente!";
}
die();


?>