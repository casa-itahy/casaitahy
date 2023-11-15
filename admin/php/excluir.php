<?php 
@session_start();
$nivel = $_SESSION['nivel'];
@session_write_close();

include_once("../includes/db.php");

$id = $_GET['id'];
$t = $_GET['t'];
if(isset($_GET['img'])) {
	$existe_img = $_GET['img'];
}

	//voltar sem perder filtros ....
	if(isset($_GET['lista'])) {
		$getLista = $_GET['lista'];
	} else {
        $getLista = '';
    }
	
	if(isset($_GET['o'])) {
		$geto = $_GET['o'];
    } else {
        $geto = '';
	}
	
	if(isset($_GET['buscar'])) {
		$getBuscar = $_GET['buscar'];
    } else {
        $getBuscar = '';
	}


//fim comentarios
#----------------- Fun��o para remover diret�rio completo ----------#
function ExcluiDir($Dir){   
    if ($dd = opendir($Dir)){
        while (false !== ($Arq = readdir($dd))) {
            if($Arq != "." && $Arq != ".."){
                $Path = "$Dir/$Arq";
                if(is_dir($Path)){
                    ExcluiDir($Path);
                }elseif(is_file($Path)){
                    unlink($Path);
                }
            }
        }
        closedir($dd);
    }
    rmdir($Dir);
}
if ($nivel==1){
#-------------------------------------------------------------------#

$sql='SELECT pag_tab_nome,id FROM modulos WHERE pag_tab_id='.$t;
$pagina = query($sql);

$tabela = $pagina[0]['pag_tab_nome'];

switch($tabela) {
	
		case 'enquete':
		$conn = conecta();
		$sql="DELETE FROM enq_respostas WHERE id_pergunta=$id;";
		$q = @mysqli_query($conn, $sql);
		
		$sql="DELETE FROM enq_perguntas WHERE id=$id;";
		$q = @mysqli_query($conn, $sql);
		
		if($q) {
			$msg = "Enquete excluida com sucesso";
			header("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
			exit();
		}

	break;
	
		case 'comentarios';
		$conn = conecta();
		$sql="DELETE FROM recados WHERE id=$id;";
		$q = @mysqli_query($conn, $sql);
		
		if($q) {
			$msg = "Comentário excluido com sucesso";
			header("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
			exit();
		}
		
	break;
	
        case'representantes': $tabela='associados';
    break;

        case'planos': $tabela='plano_individual';
    break;

		case'newsletter': $tabela='clientes';
    break;

	case 'categorias_subcat':
                $valores = explode('-',$id);
                $idpai= $valores[0];
                if(isset($valores[1])){//EXITE FILHO                    
                    $filho = $valores[1];
                    if(isset($valores[2])){
                        $neto=$valores[2];
                    }else{
                        $neto='NULL';
                    }
                }else{
                    $filho='NULL';
                    $neto='NULL';
                }
                include_once("../includes/MySQLDB.php");
                //$mysqli = conectaMysqli();
                 //AUTOTRANSATION
                //$mysqli->autocommit(FALSE);
                // $all_query_ok=true; // our control variable
                 //var_dump("DELETE FROM cat_subcat_nivel WHERE cat_pai_id='$idpai' AND cat_filho_id='$filho' AND cat_neto_id='$neto'");
                   //     die();
                $consulta=new MySQLDB();
                    $sql_array= array();
                    if($neto=='NULL'){
                        if($filho!='NULL'){        
                            //VERIFICA SE EXISTE ALGUM PRODUTO CADASTRADO COM ESTA SUBCATEGORIA(FILHO)
                            $sqlExiste = "SELECT id FROM produtos WHERE categoria_id = '$idpai' OR categoria_id='$filho' LIMIT 1;";
                            $produto = query($sqlExiste);
                            if(count($produto)>0){
                                $msg='Não foi possível excluir o registro, apague os produtos vinculados a esta subcategoria';
                                header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
                                die();
                            }
                            
                            //APAGA DADOS DA CATEGORIA PAI E FILHOS DESTE PAI
                            $sql = "SELECT cs.cat_neto_id, c.imagem
                                    FROM cat_subcat_nivel cs
                                    LEFT JOIN categorias_subcat c ON(cs.cat_filho_id = c.id)
                                    WHERE cat_filho_id='$filho'";
                            $itens = query($sql);
                            $sql_array[]=array("query" => "DELETE FROM cat_subcat_nivel WHERE cat_pai_id='$idpai' AND cat_filho_id='$filho';");
                            foreach ($itens as $item) {
                                //apagar imagem alocado no servidor para cada item
                                Imagem::excluiImagem($item['imagem']);
                                if($item['cat_neto_id']!='')
                                    $sql_array[]=array("query" => "DELETE FROM categorias_subcat WHERE id='".$item['cat_neto_id']."';");
                            }
                            if($filho!='')
                                $sql_array[]=array("query" => "DELETE FROM categorias_subcat WHERE id='$filho';");

                            $id=$filho;
                        }else{                            
                            //VERIFICA SE EXISTE ALGUM PRODUTO CADASTRADO COM ESTA CATEGORIA E SUBCATEGORIA(FILHO)
                            $sqlExiste = "SELECT id FROM produtos WHERE categoria_id IN
                                                        (SELECT cat_neto_id FROM cat_subcat_nivel WHERE cat_pai_id='$idpai') OR
                                                         categoria_id IN (SELECT cat_filho_id FROM cat_subcat_nivel WHERE cat_pai_id='$idpai') LIMIT 1;";
                            
                            $produto = query($sqlExiste);
                            if(count($produto)>0){
                                $msg='Não foi possível excluir o registro, apague os produtos vinculados a esta categoria e subcategorias';
                                header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
                                die();
                            }                            
                            $sql = "SELECT cat_neto_id FROM cat_subcat_nivel WHERE cat_pai_id='$idpai';";
                            $itensNeto = query($sql);
                            $sql = "SELECT cat_filho_id FROM cat_subcat_nivel WHERE cat_pai_id='$idpai';";
                            $itensFilho = query($sql);
                            $sql_array[]=array("query" => "DELETE FROM cat_subcat_nivel WHERE cat_pai_id='$idpai';");
                            foreach ($itensNeto as $item) {
                                if($item['cat_neto_id']!='')
                                    $sql_array[]=array("query" => "DELETE FROM categorias_subcat WHERE id='".$item['cat_neto_id']."';");
                            }
                            foreach ($itensFilho as $item) {
                                if($item['cat_filho_id']!='')
                                    $sql_array[]=array("query" => "DELETE FROM categorias_subcat WHERE id='".$item['cat_filho_id']."';");
                            }                            
                            $sql_array[]=array("query" => "DELETE FROM categorias_subcat WHERE id='$idpai';");
                            $id=$idpai;
                        }
                    }else{
                        //VERIFICA SE EXISTE ALGUM PRODUTO CADASTRADO COM ESTA CATEGORIA E SUBCATEGORIA(NETO)
                        $sqlExiste = "SELECT id FROM produtos WHERE categoria_id='$neto') LIMIT 1;";
                        $produto = query($sqlExiste);
                        if(count($produto)>0){
                            $msg='Não foi possível excluir o registro, apague os produtos vinculados a esta subcategoria';
                            header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
                            die();
                        }
                        $sql_array[]=array("query" => "DELETE FROM cat_subcat_nivel WHERE cat_pai_id='$idpai' AND cat_filho_id='$filho' AND cat_neto_id='$neto';");
                        if($neto!='')
                            $sql_array[]=array("query" => "DELETE FROM categorias_subcat WHERE id=$neto;");
                        $id=$neto;
                    }

                    //var_dump($sql_array);
                    $all_query_ok = $consulta->transaction($sql_array);

                    if($all_query_ok){
                        $msg='Item excluído!';
                    }else{
                        $msg='Não foi possível excluir o registro, apague os produtos vinculados a esta categoria';
                    }
                    break;
        
         case 'paginas':
                $valores = explode('-',$id);
                $idpai= $valores[0];
                if(isset($valores[1])){//EXISTE FILHO
                    $filho = $valores[1];
                    if(isset($valores[2])){
                        $neto=$valores[2];
                    }else{
                        $neto='NULL';
                    }
                }else{
                    $filho='NULL';
                    $neto='NULL';
                }
                include_once("../includes/MySQLDB.php");
              
                $consulta=new MySQLDB();
                    $sql_array= array();
                    if($neto=='NULL'){
                        if($filho!='NULL'){
                            //APAGA DADOS DA CATEGORIA PAI E FILHOS DESTE PAI
                            $sql = "SELECT cs.pag_neto_id, p.imagem
                                    FROM pag_subpag_nivel cs
                                    LEFT JOIN paginas p ON(cs.pag_filho_id = p.id)
                                    WHERE pag_filho_id='$filho'";
                            $itens = query($sql);
                            $sql_array[]=array("query" => "DELETE FROM pag_subpag_nivel WHERE pag_pai_id='$idpai' AND pag_filho_id='$filho';");
                            foreach ($itens as $item) {
                                //apagar imagem alocado no servidor para cada item
                                Imagem::excluiImagem($item['imagem']);
                                if($item['cat_neto_id']!='')
                                    $sql_array[]=array("query" => "DELETE FROM paginas WHERE id='".$item['pag_neto_id']."';");
                            }
                            if($filho!='')
                                $sql_array[]=array("query" => "DELETE FROM paginas WHERE id='$filho';");

                            $id=$filho;
                        }else{                            
                            //VERIFICA SE EXISTE ALGUM PRODUTO CADASTRADO COM ESTA CATEGORIA E SUBCATEGORIA(FILHO)
                            $sql = "SELECT pag_neto_id FROM pag_subpag_nivel WHERE pag_pai_id='$idpai';";
                            $itensNeto = query($sql);
                            $sql = "SELECT pag_filho_id FROM pag_subpag_nivel WHERE pag_pai_id='$idpai';";
                            $itensFilho = query($sql);
                            $sql_array[]=array("query" => "DELETE FROM pag_subpag_nivel WHERE pag_pai_id='$idpai';");
                            foreach ($itensNeto as $item) {
                                if($item['pag_neto_id']!='')
                                    $sql_array[]=array("query" => "DELETE FROM paginas WHERE id='".$item['pag_neto_id']."';");
                            }
                            foreach ($itensFilho as $item) {
                                if($item['pag_filho_id']!='')
                                    $sql_array[]=array("query" => "DELETE FROM paginas WHERE id='".$item['pag_filho_id']."';");
                            }                            
                            $sql_array[]=array("query" => "DELETE FROM paginas WHERE id='$idpai';");
                            $id=$idpai;
                        }
                    }else{
                        //VERIFICA SE EXISTE ALGUM PRODUTO CADASTRADO COM ESTA CATEGORIA E SUBCATEGORIA(NETO)
                        $sql_array[]=array("query" => "DELETE FROM pag_subpag_nivel WHERE pag_pai_id='$idpai' AND pag_filho_id='$filho' AND pag_neto_id='$neto';");
                        if($neto!='')
                            $sql_array[]=array("query" => "DELETE FROM paginas WHERE id=$neto;");
                        $id=$neto;
                    }

                    //var_dump($sql_array);
                    $all_query_ok = $consulta->transaction($sql_array);

                    if($all_query_ok){
                        $msg='Item excluído!';
                    }else{
                        $msg='Não foi possível excluir o registro';
                    }
                    break;           
	
	case 'produtos':
            $sql = "SELECT pasta FROM img_pasta_prod WHERE produto_id='$id'";
            $pasta = query($sql);
            if ($pasta[0]['pasta']){
                $dir = "../imagens/".$pasta[0]['pasta']."/";
                @ExcluiDir($dir);
                $conn = conecta();
                $sql="DELETE FROM img_pasta_prod WHERE produto_id='$id';";
                $q = @mysqli_query($conn, $sql);
            }
            $t.='&tipo=p';
	break;
	
	case 'albuns':            
            $sql = "SELECT pasta FROM img_pasta_albuns WHERE albuns_id='$id'";
            $pasta = query($sql);
            if (isset($pasta[0]['pasta'])){
                    $dir = "../imagens/".$pasta[0]['pasta']."/";
                    @ExcluiDir($dir);
                    $conn = conecta();
                    $sql="DELETE FROM img_pasta_albuns WHERE albuns_id='$id';";
                    $q = @mysqli_query($conn, $sql);
            }
        break;
        
        case 'recados':                        
            $conn = conecta();
            $sql="DELETE FROM recados_noticias WHERE recados_id=$id;";
            $q = @mysqli_query($conn, $sql);
            
        break;

        case 'usuarios':            
                $conn = conecta();
                $sql="DELETE FROM usuarios_modulos WHERE usuario_id='$id';";
                $q = @mysqli_query($conn, $sql);
        

	break;		
    
        case 'newsletter':            
                $conn = conecta();
                $sql="UPDATE clientes SET newsletter=0 WHERE id='$id';";                
                $q = @mysqli_query($conn, $sql);
	break;
	
		case 'agenda':
		
				$conn = conecta();
				$sql="DELETE FROM noticias WHERE id='$id';";
				$q = mysqli_query($conn, $sql);
                $msg='Evento excluído!';
				echo('<meta http-equiv="refresh" content="0;URL=../index.php?pag='.$t.'&lista='.$getLista.'&o='.$geto.'&buscar='.$getBuscar.'&tipo=p&msg='.$msg.'">');
				exit();
	break;

		case 'videos':

				$conn = conecta();
				$sql="DELETE FROM noticias WHERE id='$id';";
				$q = mysqli_query($conn, $sql);
                $msg='Vídeo excluído!';
				echo('<meta http-equiv="refresh" content="0;URL=../index.php?pag='.$t.'&lista='.$getLista.'&o='.$geto.'&buscar='.$getBuscar.'&tipo=p&msg='.$msg.'">');
				exit();
	break;
    
        case 'clientes':                
                $sql="SELECT docs_id FROM clientes_docs WHERE clientes_id='$id';";                
                $res = query($sql);                
                if(count($res)>0){
                    $conn = conecta();
                    $sql="DELETE FROM clientes_docs WHERE clientes_id='$id';";
                    $q = mysqli_query($conn, $sql);                    
                    foreach($res as $r){
                        $sql="DELETE FROM docs WHERE id='".$r['docs_id']."';";                         
                        $q = mysqli_query($conn, $sql);
                    }                                        
                }
				$conn = conecta();
                $sql="DELETE FROM clientes WHERE id='$id';";
                $q = mysqli_query($conn, $sql);
	break;
}

if(isset($existe_img)) {
    if(($tabela!='kit')AND($tabela!='itens')AND($tabela!='usuarios')AND($tabela!='clientes')AND($tabela!='newsletter')AND($tabela!='paginas')AND($tabela!='categorias_subcat')AND($tabela!='associados')AND(($existe_img!=0)OR($existe_img==NULL))){
        $sql = "SELECT imagem FROM $tabela WHERE id=$id ";
        $retorno = @query($sql);
        if ($retorno[0]['imagem'] != ""){
            $caminho = "../imagens/".$tabela."/".$retorno[0][imagem];
            if (file_exists($caminho)){
                    unlink ($caminho);
            }
            $caminho = "../imagens/".$tabela."/thumb_".$retorno[0][imagem];
            if (file_exists($caminho)){
                unlink ($caminho);
            }
        }
    }
}

	if($t!='categorias_subcat' && $tabela!='newsletter'){
            $sql = "DELETE FROM $tabela WHERE id=$id ";            
            $conn = conecta();
            $q = @mysqli_query($conn, $sql);
            if(!$q){
                    @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);                    
                    $msg = "Erro ao realizar a operação!".$sql;
            }else{
                    @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
                    $msg = "Operação realizada com sucesso!";
            }
        }
	
    if(!isset($getLista)) { $getLista=''; }
    if(!isset($geto)) { $geto=''; }
    if(!isset($getBuscar)) { $getBuscar=''; }

	echo('<meta http-equiv="refresh" content="0;URL=../index.php?pag='.$t.'&lista='.$getLista.'&o='.$geto.'&buscar='.$getBuscar.'&tipo=p&msg='.$msg.'">');
}else{
	$msg = "Somente usuário administrador pode excluir!";
	//header("Location:../index.php?pag=".$t."&lista=".$getLista."&o=".$geto."&buscar=".$getBuscar."&tipo=p&msg=".$msg." ");
	echo('<meta http-equiv="refresh" content="0;URL=../index.php?pag='.$t.'&lista='.$getLista.'&o='.$geto.'&buscar='.$getBuscar.'&tipo=p&msg='.$msg.'">');
}

class Imagem{
    static function excluiImagem($descricao){
         if ($descricao != ""){
                if($tabela=='categorias_subcat')$tab='categorias'; else $tab=$tabela;
                $caminho = "../imagens/".$tab."/".$descricao;
                if (file_exists($caminho)){
                        unlink ($caminho);
                }
                $caminho = "../imagens/".$tab."/thumb_".$descricao;
                if (file_exists($caminho)){
                        unlink ($caminho);
                }
        }
    }
}


?>