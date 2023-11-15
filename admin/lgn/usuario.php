<?php

class Usuario {
  var $nome, $senha;
 
function __construct($usuario,$senha){
   $this->usuario  = $usuario;
   $this->senha = sha1($senha);
}

function autentica(){
   $usuario  = $this->usuario;
   $senha = $this->senha;
   
   $sql = "SELECT * FROM usuarios WHERE login='$usuario' AND senha='$senha'";
   $usuario = query($sql);
   $tamanho = count($usuario);

   if ($tamanho > 0){       
	$this->geraSessao($usuario);
        return true;
   }else{    
   	return false;
   }
  }

function geraSessao($usuario) {
   session_start();
   $id_user = $usuario[0]['id'];
   $_SESSION['id'] = $usuario[0]['id'];   
   $_SESSION['nome_adm'] = $usuario[0]['nome'];
   $_SESSION['nivel'] = $usuario[0]['nivel'];
	
   if ($id_user == 1){
            $sql = "SELECT titulo, indice, descricao, pag_tab_nome, pag_tab_id, id_pai_submenu FROM modulos WHERE status!=0 AND pag_tab_id!=0 ORDER BY indice";
            $pages = query($sql);
   }else{
       $sql = "SELECT modu.titulo, modu.indice, modu.descricao, modu.pag_tab_nome, modu.pag_tab_id, modu.id_pai_submenu
                FROM usuarios_modulos um
                LEFT JOIN modulos modu ON (um.modulo_id = modu.id)
                WHERE um.usuario_id='$id_user' AND modu.status!=0 AND modu.pag_tab_id!=0 ORDER BY modu.indice";
       $pages = query($sql);
       
   }
    
   foreach($pages as $pg){
        $k = $pg['pag_tab_id'];
        $_SESSION['pages'][$k]['titulo'] = $pg['titulo'];
        $_SESSION['pages'][$k]['pag_tab_nome'] = $pg['pag_tab_nome'];
        $_SESSION['pages'][$k]['pag_tab_id'] = $pg['pag_tab_id'];
        $_SESSION['pages'][$k]['id_pai_submenu'] = $pg['id_pai_submenu'];
        $_SESSION['pag_atual_id']=0;
        $_SESSION['pag_atual_nome']='';
   }
  }
 }
?>