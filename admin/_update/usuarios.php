<?php 
	include("../php/sessao.php");
        session_write_close();
	include("../includes/db.php");
	include ("../php/funcoes.php");

        $sql = "UPDATE usuarios SET
        nome='".$_POST['nome']."',
        login = '".$_POST['login']."',
        nivel='".$_POST['nivel']."',
        modified =NOW() WHERE id=".$_POST['id'];

        $conn = conecta();
	$q = @mysqli_query($conn, $sql);
	if($q != false){
            $sql = "SELECT m.id,m.descricao
                        FROM modulos m
                            INNER JOIN usuarios_modulos um ON (m.id = um.modulo_id)
                                WHERE um.usuario_id= '".$_POST['id']."' AND m.status=1 ";//AND m.pag_tab_nome!='usuarios' AND m.pag_tab_nome!='config'";

                        $usuario_modulo = query($sql);

                        $modulos_marcado=array();
                        if(count($usuario_modulo)>0){
                            foreach ($usuario_modulo as $m){
                                $modulos_marcado[]=$m['id'];
                            }
                        }

                        $sql = "SELECT id,descricao FROM modulos WHERE status=1 "; //AND pag_tab_nome!='usuarios' AND pag_tab_nome!='config'";
                        $modulos = query($sql);

                        //APAGAR OS ITENS QUE EXISTEM E NÃO FORAM DESMARCADOS
                        foreach($modulos as $item){
                            //EXISTE PERMISSAO DA PAGINA(MODULO)PARA ESTE USUARIO NA TABELA USUARIO_MODULO?                            
                            if(in_array($item['id'],$modulos_marcado)){
                                //SE SIM, verifica se foi selecionado no checkbox
                                if(!$_POST[$item['id']]){//Se nõ foi selcionado no checkbox, apagar o registro
                                    $sql = "DELETE FROM usuarios_modulos WHERE usuario_id='".$_POST['id']."' AND modulo_id='".$item['id']."'; ";                                    
                                    $conn = conecta();
                                    @mysqli_query($conn, $sql);
                                }
                            }else{
                                //NÃO EXISTE PERMISSAO DA PAGINA(MODULO)PARA ESTE USUARIO NA TABELA USUARIO_MODULO
                                //Verifica se foi selecionado no checkbox
                                if($_POST[$item['id']]==1){
                                    $sql="INSERT INTO usuarios_modulos(usuario_id,modulo_id)VALUES(".$_POST['id'].",".$item['id'].")";                                    
                                    $conn = conecta();
                                    @mysqli_query($conn, $sql);
                                 }
                            }
                        }
                        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
                        $msg = "Operação realizada com sucesso!";
        }else{
            $msg = "Não foi possível salvar os dados! Tente novamente ou contate seu adminitrador.";
        }
        
        
if (!headers_sent($filename, $linenum)) {
    header('Location: ../index.php?pag=7&tipo=p&msg='.$msg);
    exit;
}

?>