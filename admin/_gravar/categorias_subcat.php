<?php 
include("../includes/db.php");
include("../includes/MySQLDB.php");
include ("../php/funcoes.php");
include("../php/imgCaminho.php");
include("../../php/plugins/seo.php");

extract($_POST);


$sql = "SELECT * FROM idiomas WHERE status=1";
$idiomas = query($sql);
$modulo = query("SELECT orientacao, tam_principal, tam_thumb, modulo_gemeo FROM modulos WHERE pag_tab_id='".$pag."';");

/* Procura a ultima posi��o */
$posicao = ultimaPosicao('categorias_subcat');
$posicao = $posicao + 1;

/* Envia a imagem para redimensionamento */
$imagemUP = $_FILES['imagem'];

if (count($imagemUP) != 0 ){
  if ($imagemUP['error'] == 0 ) {
    $imagem = gravaImagem($imagemUP, $tabela, $modulo['0']['tam_principal'], $modulo['0']['tam_thumb'], $modulo['0']['orientacao']);
    if (!$imagem) {
      $imagem = ''; 
    }
  }
}

$valores = explode('-',$pai);
if($valores[1]){
    $pai = $valores[0];
    $filho = $valores[1];    
}else{
    $pai = $pai;
    $filho='NULL';
}  
  //$mysqli = conectaMysqli();
  //AUTOTRANSATION
  //$mysqli->autocommit(FALSE);
  //$all_query_ok=true; // our control variable
$noticia_id=0;
$erro=true;

foreach($idiomas as $idioma){    
    $idioma_id = $idioma['id'];
    $sigla = $idioma['sigla'];
    $titulo = $_POST['titulo'.$sigla];    
    $texto = $_POST['texto'.$sigla];
  
  
  //pegar caminho das imagens no editor
  
  $newTexto = pegaImg($texto);
  
  //echo $newTexto;
  
  //echo $base;
  
  //exit();
  
    //$titulo = mysql_escape_string($titulo);
    //$texto = mysql_escape_string($texto);

    
    $conn = conecta(); 
    if(strtolower(trim($sigla))=='port'){        
              $consulta = new MySQLDB();

              if($filho=='NULL'){
                  $sql1="INSERT INTO categorias_subcat(titulo, subtitulo, conteudo, descricao, video, exibicao, mostraTitulo, posicao, imagem, created, modified, tipo)
                                VALUES('$titulo', '$subtitulo', '$newTexto', '$descricao', '$video', '$exibicao', '$mostraTitulo', '$posicao', '$imagem', NOW(), NOW(), '".$modulo[0]['modulo_gemeo']."')";
                  $sql2="SELECT @A:=MAX(id) FROM categorias_subcat";

                   if($pai==0){
                      $sql3="INSERT INTO cat_subcat_nivel(cat_pai_id) VALUES(@A)";
                   }else{
                       $sql4="INSERT INTO cat_subcat_nivel(cat_pai_id,cat_filho_id) VALUES('$pai',@A)";
                   }
                 $q = array (
                     array("query" => $sql1),
                     array("query" => $sql2),
                     array("query" => $sql3),
                     array("query" => $sql4),
                  );
              }else{
                  $sql1 = "INSERT INTO categorias_subcat(titulo, conteudo, posicao, imagem, created, modified, tipo)
                                VALUES('$titulo', '$newTexto', '$posicao', '$imagem', NOW(), NOW(), '".$modulo[0]['modulo_gemeo']."')";
                  $sql2= "SELECT @A:=MAX(id) FROM categorias_subcat";
                  $sql3= "INSERT INTO cat_subcat_nivel(cat_pai_id,cat_filho_id, cat_neto_id) VALUES($pai, $filho, @A)";
                  $q = array (
                     array("query" => $sql1),
                     array("query" => $sql2),
                     array("query" => $sql3),      
                  );      
              }
              $all_query_ok = $consulta->transaction($q);
              if($all_query_ok){     
                     $msg ="<p>Os dados foram salvos!</p>";
              }else{     
                     $msg ="<p>Ocorreu um problema durante a gravação no banco de dados.</p><p>Caso continue o problema, comunique seu administrador.</p>";
              }
              //var_dump($msg);die();
        
        //GRAVANDO LINK NA TABELA LINKS
        //pegando a pagina
        //$nomePg = query("SELECT * FROM modulos WHERE id='".$pag."';");
        //$nmPagina = $nomePg[0]['pag_tab_nome'];
        
        $pegaUltimoId = query("SELECT * FROM categorias_subcat ORDER BY id DESC LIMIT 1");
        $pagina_id = $pegaUltimoId[0]['id'];


  
    //link
    //verrificar se o link não ira ser duplicado
    $link = limpaURL($title);
    $verifica = query("SELECT * FROM links WHERE lin_nome = '$link'");
    $nmPagina = "produtos_categ";

    //caso exista ja um link igual este, entao será adicionado a data do cadastro no final deste link, a data no formato dd-mm-yyyy !!!SEM AS BARAS!!!
    if(count($verifica) >0 ) {
      $dia = date("d-m-i");
      $link = $link."-".$dia;
    }
    
    //link url
    $gravaLink = "INSERT INTO links (lin_pagina, lin_nome, title, metad, lin_id_pg, tipo) VALUES ('$nmPagina', '$link', '$title', '$metad', '$pagina_id', 3)";
    gravar($gravaLink);
    }else{
        $categorias = query("SELECT MAX(id) as id_categoria FROM categorias_subcat");
        $conn = conecta();
        $sql = "INSERT INTO categorias_idioma(titulo, conteudo, idioma_id, categoria_id)
                                VALUES('$titulo', '$newTexto', '$idioma_id', '".$categorias[0]['id_categoria']."');";
        $q = @mysql_query($sql,$conn);     
        //var_dump($sql,mysql_error($conn));die();
    
    //GRAVANDO LINK NA TABELA LINKS
    //pegando a pagina
    //$nomePg = query("SELECT * FROM modulos WHERE id='".$pag."';");
    //$nmPagina = $nomePg[0]['pag_tab_nome'];
    
    }
}
if (!headers_sent($filename, $linenum)) {
  header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
    exit;
}

?>