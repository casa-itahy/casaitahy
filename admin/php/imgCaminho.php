<?php
	//pegar caminho das imagens no editor
	function pegaImg($texto) {
	
			if(stripos($_SERVER['SERVER_ADMIN'], "localhost") !== false){
				#Local#
				$raiz = explode("/", $_SERVER['REQUEST_URI']);
				$base = $_SERVER['HTTP_HOST']."/".$raiz[1]."/";
				$pegaPasta = "/".$raiz[1]."/admin";

				
			}elseif(stripos($_SERVER['HTTP_HOST'], "artwebdigital.com.br") !== false){
				#online servidor art web#
				$raiz = explode("/", $_SERVER['REQUEST_URI']);
				$base = $_SERVER['HTTP_HOST']."/".$raiz['1']."/".$raiz['2']."/";
				$pegaPasta = "/".$raiz[1]."/".$raiz['2']."/admin";
				
			}else{
				#online#
				$raiz = explode("/", $_SERVER['REQUEST_URI']);
				$base = $_SERVER['HTTP_HOST']."/".$raiz['1']."/";
				$pegaPasta = "/admin";
			}
	
		//$pegaPasta = "admin/kcfinder/upload/images/";
		$novoTexto = str_replace($pegaPasta, "admin", $texto);
		
		return addslashes($novoTexto);
		
		

	}
?>