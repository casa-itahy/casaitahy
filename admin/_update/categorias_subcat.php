<?php 
  include_once("../php/sessao.php");
        session_write_close();
  include_once("../includes/db.php");        
  include_once("../php/funcoes.php");
  include("../php/imgCaminho.php");
  include("../../php/plugins/seo.php");

extract($_POST);

$idiomas = query("SELECT * FROM idiomas WHERE status=1");
$modulo = query("SELECT orientacao, tam_principal, tam_thumb FROM modulos WHERE pag_tab_id='".$pag."';");

if (!empty($_FILES['imagem'])) {
  $imagemUP = $_FILES['imagem'];
  if ($imagemUP['error'] == 0 ) {
    $imagem = gravaImagem($imagemUP, 'categorias_subcat', $modulo['0']['tam_principal'], $modulo['0']['tam_thumb'], $modulo['0']['orientacao']);
    if (!$imagem) {
      $UPimagem = "";
    } else {
      $UPimagem = "imagem='$imagem',";
    }
  }
}else{
  $UPimagem =' ';
}

$valores = explode('-',$oldpai);
if(isset($valores[1])){
    $oldpai = $valores[0];
    $oldfilho = $valores[1];
    if(isset($valores[2])){
        $oldid=$valores[2];
        $oldneto=$valores[2];
    }else{
        $oldid=$valores[1];
        $oldneto='NULL';
    }
}else{
    $oldpai = $valores[0];
    $oldid=$valores[0];
    $oldfilho='NULL';
    $oldneto='NULL';
}

if ($oldpai != $pai){
  $sql = "SELECT MAX(posicao)
                FROM categorias_subcat WHERE id='$pai' ";
  $retorno = query($sql);
  $posicao = $retorno[0]['MAX(posicao)'];
  $posicao = $posicao + 1;
  $inclusao = " idpai = '$pai', posicao = '$posicao',";
}
$valores = explode('-',$pai);

if(isset($valores[1])){
    $pai = $valores[0];
    $filho = $valores[1];
    if(isset($valores[2])){
        $id=$valores[2];        
    }else{
        $id=$valores[1];        
    }
}else{    
    $id=$pai;
    $filho='NULL';
}

  //$mysqli = conectaMysqli();
  //AUTOTRANSATION
  //$mysqli->autocommit(FALSE);
  //$all_query_ok=true; // our control variable
  //$consulta = new MySQLDB();

  if($oldfilho=='NULL'){
    $oldfilho="cat_filho_id IS NULL";
  }else{
    $id_categoria=$oldfilho;
    $oldfilho="cat_filho_id='$oldfilho'";    
  }

  if($oldneto=='NULL'){
    $oldneto="AND cat_neto_id IS NULL";
  }else{
      $id_categoria=$oldneto;
    $oldneto='AND cat_neto_id='.$oldneto;        
  }


$erro=true;
foreach($idiomas as $idioma){
    $idioma_id = $idioma['id'];
    $sigla = $idioma['sigla'];
    $titulo = $_POST['titulo'.$sigla];    
    $texto = $_POST['texto'.$sigla];
    //$titulo = mysql_escape_string($titulo);
    //$texto = mysql_escape_string($texto);
  
  //pegar caminho das imagens no editor
  

  
  $newTexto = pegaImg($texto);
  
  //echo $newTexto;
  
  //echo $base;
  
  //exit();
    
    if(strtolower(trim($sigla))=='port'){
        $conn = conecta();
        $sql1="UPDATE categorias_subcat SET titulo='$titulo', subtitulo='$subtitulo', conteudo='$newTexto', descricao='$descricao', video='$video', exibicao='$exibicao', mostraTitulo='$mostraTitulo', ".$UPimagem." modified =NOW() WHERE id=$oldid;";
        $q = @mysqli_query($conn, $sql1);
    }else{
        $conn = conecta();
        $sql="UPDATE categorias_idioma SET titulo='$titulo', conteudo='$newTexto' WHERE categoria_id=$oldid AND idioma_id=$idioma_id";        
        $q = @mysqli_query($conn, $sql);          
        
        if(mysql_affected_rows($conn)==0){
            $sql="INSERT INTO categorias_idioma(categoria_id,idioma_id,titulo,conteudo)VALUES('$oldid','$idioma_id','$titulo','$newTexto')";
            $q = @mysqli_query($conn, $sql);
        }
    }
}

  $link = limpaURL($title);
    $verifica = query("SELECT * FROM links WHERE lin_nome = '$link' AND lin_id_pg <> $oldid");
    
    //caso exista ja um link igual este, entao será adicionado a data do cadastro no final deste link, a data no formato dd-mm-yyyy !!!SEM AS BARAS!!!
    if(count($verifica) >0 ) {
      $dia = date("d-y-i");
      $link = $link."-".$dia;
    }

  $conn = conecta();
  $upLink = "UPDATE links SET title='$title', metad='$metad', lin_nome = '$link' WHERE lin_id_pg = '$oldid' AND tipo = 3";
  $q2 = @mysqli_query($conn, $upLink);
  
  
  if($q != false){
      if($filho=='NULL'||empty($filho)){
            //ALTERA SOMENTE O PAI
            if($id!=0){
                //var_dump('altera o pai ',"UPDATE cat_subcat_nivel SET cat_pai_id=$id, cat_filho_id=$oldpai,cat_neto_id=NULL WHERE cat_pai_id='$oldpai' AND $oldfilho ".$oldneto);
                if($id_categoria=='') $id_categoria=$oldpai;
                $sql2="UPDATE cat_subcat_nivel SET cat_pai_id=$id, cat_filho_id=$id_categoria,cat_neto_id=NULL WHERE cat_pai_id='$oldpai' AND $oldfilho ".$oldneto.";";
            }else{
                //'altera o pai para nenhuma categoria, no caso é ela mesma';
                //var_dump('altera o pai para nenhuma',"UPDATE cat_subcat_nivel SET cat_pai_id=$id_categoria, cat_filho_id=NULL,cat_neto_id=NULL WHERE cat_pai_id='$oldpai' AND $oldfilho ".$oldneto);
                if($id_categoria=='') $id_categoria=$oldid;
                $sql2="UPDATE cat_subcat_nivel SET cat_pai_id='$id_categoria',cat_filho_id=NULL,cat_neto_id=NULL WHERE cat_pai_id='$oldpai' AND $oldfilho ".$oldneto.";";
            }
      }else{//ALTERA PELA BUSCA
          if($oldneto!='NULL')
                $neto=$oldneto;

          //var_dump('altera para filho ou neto',"UPDATE cat_subcat_nivel SET cat_pai_id='$pai',cat_filho_id='$filho',cat_neto_id='$oldpai' WHERE cat_pai_id='$oldpai' AND $oldfilho ".$oldneto);
          $sql2="UPDATE cat_subcat_nivel SET cat_pai_id='$pai',cat_filho_id='$filho',cat_neto_id='$oldid' WHERE cat_pai_id='$oldpai' AND $oldfilho ".$oldneto.";";
      }
      //var_dump($sql2);
      //die();
      $q = @mysqli_query($conn, $sql2);
  }  
  @mysqli_close($conn);
  /*$q = array (
         array("query" => $sql1),
         array("query" => $sql2),
      );*/
//$all_query_ok = $consulta->transaction($q);

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