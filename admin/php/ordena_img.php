<?php
if ($_POST) {    
        include_once("sessao.php");
        include_once('../includes/db.php');

        $ids = $_POST["ids"];
        $conn = conecta();
        for ($ordem=0; $ordem < count($ids); $ordem++){
                $id_array = explode(',',$ids[$ordem]);
                $sql = "UPDATE banners SET ordem=".($ordem+1)." WHERE id='".$id_array[0]."' AND grupo='".$id_array[1]."';";
                $q = mysqli_query($conn, $sql);                
                if($q!=true){
                    echo mysqli_error($conn);
                    die();
                }
        }
        //echo $sql;die();        
        //$sql = "UPDATE itens_prod_bloco SET ordem='$ordem' WHERE produto_id=$prod_id AND bloco_id=$bloco_id AND itens_id=$item_id";
        
        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
        

        return $ids;
}
die();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
