<?php 
include("../php/sessao.php");
include("../includes/db.php");

$id = $_GET['id'];
$t = $_GET['t'];
$existe_img = $_GET['img'];
#----------------- Fun��o para remover diret�rio completo ----------#
function ExcluiDir($Dir){   
    if ($dd = opendir($Dir)) 
	{
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
if ($_SESSION['nivel']==1){
#-------------------------------------------------------------------#

$sql='SELECT pag_tab_nome,id FROM modulos WHERE pag_tab_id='.$t;
$pagina = query($sql);

$tabela = $pagina[0]['pag_tab_nome'];

switch($tabela) {
        case'representantes': $tabela='associados';

	case 'categorias_subcat':
                $valores = explode('-',$id);
                $idpai= $valores[0];
                if($valores[1]){//EXITE FILHO                    
                    $filho = $valores[1];
                    if($valores[2]){                        
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
            if ($pasta[0]['pasta']){
                    $dir = "../imagens/".$pasta[0]['pasta']."/";
                    @ExcluiDir($dir);
                    $conn = conecta();
                    $sql="DELETE FROM img_pasta_albuns WHERE albuns_id='$id';";
                    $q = @mysqli_query($conn, $sql);
            }
        break;

        case 'usuarios':            
                $conn = conecta();
                $sql="DELETE FROM usuarios_modulos WHERE usuario_id='$id';";
                $q = @mysqli_query($conn, $sql);
        

	break;		
}        
	if (($tabela!='kit')AND($tabela!='itens')AND($tabela!='usuarios')AND($tabela!='newsletter')AND($tabela!='paginas')AND($tabela!='categorias_subcat')AND($tabela!='associados')AND(($existe_img!=0)OR($existe_img==NULL))){
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
	if($t!='categorias_subcat'){
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
	
	header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
}else{
	$msg = "Somente usuário administrador pode excluir!";
	header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
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