<?php 

  include_once("../php/sessao.php");
        session_write_close();
  include_once("../includes/db.php");        
  include_once("../php/funcoes.php");
  include("../php/imgCaminho.php");
  include("../../php/plugins/seo.php");

extract($_POST);

  $erro=true;

    $conn = conecta();
    $sql1="UPDATE categorias_noticias SET titulo = '$titulo', titulo_ingles = '$titulo_ing', titulo_espanhol = '$titulo_esp', modified = NOW() WHERE id=$id";

    $q = mysqli_query($conn, $sql1);

    $link = limpaURL($title);
    $verifica = query("SELECT * FROM links WHERE lin_nome = '$link' AND lin_id_pg <> $id");
    
    //caso exista ja um link igual este, entao será adicionado a data do cadastro no final deste link, a data no formato dd-mm-yyyy !!!SEM AS BARAS!!!
    if(count($verifica) >0 ) {
      $dia = date("d-y-i");
      $link = $link."-".$dia;
    }

    $conn = conecta();
    $upLink = "UPDATE links SET title='$title', metad='$metad', lin_nome = '$link' WHERE lin_id_pg = '$id' AND tipo = 8";
    $q2 = @mysqli_query($conn, $upLink);

    if($q=='' || $q==true){
      $msg ="Categoria alterada!";     
    }else{
      $msg ="<p>Não foi possível alterar o dados</p>
        <p>Caso continue o problema, comunique seu administrador.</p>".$q;
    }

  if (!headers_sent($filename, $linenum)) {
      header('Location:../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
      exit;
  }

?>