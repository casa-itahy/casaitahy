<?php 
include("../includes/db.php");
include("../php/sessao.php");
session_write_close();

	//voltar sem perder filtros ....
	if(isset($_GET['lista'])) {
		$getLista = $_GET['lista'];
	}
	
	if(isset($_GET['o'])) {
		$geto = $_GET['o'];
	}
	
	if(isset($_GET['buscar'])) {
		$getBuscar = $_GET['buscar'];
	}



        $t = $_GET[t];
		$idEdit = $_GET[idEdit];
		$tipoSelect = $_GET[tipoSelect];

        switch($t) {
                case 1:
                $tabela = "paginas";
                break;

                case 2:
                $tabela = "categorias_subcat";
                break;
				
				case 31:
				$tabela = "enq_perguntas";
				$sql = "UPDATE $tabela SET status=0";
                $conn = conecta();
				$q = mysqli_query($conn, $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                break;

                case 3:
                $tabela = "produtos";
                break;

                case 4:
                $tabela = "albuns";
                break;

                case 5:
                $tabela = "noticias";
                break;
				
				case 21:
                $tabela = "noticias";
                break;
				
				case 32:
                $tabela = "recados";
                break;
				
				case 33:
                $tabela = "recados";
                break;

                case 36:
                $tabela = "noticias";
                break;				
				
				//recados das noticias
				case 50:
				$tabela = "recados";
				
				if(isset($_POST['v'])){
					$id = $_POST['id'];
					$v = $_POST['v'];
				}else{
					$id = $_GET[id];
					$v = $_GET[v];
				}
				
						$valores = explode('-',$id);
						if($valores[1]){//EXITE FILHO            
							if($valores[2])
								$id=$valores[2];
							else
								$id = $valores[1];
						}else{
							$id = $valores[0];
						}
				
				
					$sql = "UPDATE $tabela SET status=$v WHERE id=$id ";
					
					$conn = conecta();
					$q = mysqli_query($conn, $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					if($q == false){ 
						@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
						erro('
							<p>Ocorreu um problema durante a gravação no banco de dados mysql!</p>
							<p>O erro encontrado foi:</p>
							<p>'.mysqli_error($GLOBALS["___mysqli_ston"]).'</p>
						');		
					}else{
						@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
						header("location:../index.php?pag=5&tipo=e&id=".$idEdit."");
						exit();
					}
					
				//fim recados das noticias
				
				//recados nos albuns
				case 51:
				$tabela = "recados";
				
				if(isset($_POST['v'])){
					$id = $_POST['id'];
					$v = $_POST['v'];
				}else{
					$id = $_GET[id];
					$v = $_GET[v];
				}
				
						$valores = explode('-',$id);
						if($valores[1]){//EXITE FILHO            
							if($valores[2])
								$id=$valores[2];
							else
								$id = $valores[1];
						}else{
							$id = $valores[0];
						}
				
				
					$sql = "UPDATE $tabela SET status=$v WHERE id=$id ";
					
					$conn = conecta();
					$q = mysqli_query($conn, $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					if($q == false){ 
						@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
						erro('
							<p>Ocorreu um problema durante a gravação no banco de dados mysql!</p>
							<p>O erro encontrado foi:</p>
							<p>'.mysqli_error($GLOBALS["___mysqli_ston"]).'</p>
						');		
					}else{
						@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
						header("location:../index.php?pag=4&tipo=e&id=".$idEdit."");
						exit();
					}
					
				//fim recados nos albuns
            
                default:
                    $sql='SELECT pag_tab_nome,id FROM modulos WHERE pag_tab_id='.$t;
                    $pagina = query($sql);
                    $tabela = $pagina[0]['pag_tab_nome'];
        }

if(isset($_POST['v'])){
    $id = $_POST['id'];
    $v = $_POST['v'];
}else{
    $id = $_GET[id];
    $v = $_GET[v];
}

        $valores = explode('-',$id);
        if($valores[1]){//EXITE FILHO            
            if($valores[2])
                $id=$valores[2];
            else
                $id = $valores[1];
        }else{
            $id = $valores[0];
        }


	$sql = "UPDATE $tabela SET status=$v WHERE id=$id ";
	
	$conn = conecta();
	$q = mysqli_query($conn, $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	if($q == false){ 
		@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
		erro('
			<p>Ocorreu um problema durante a gravação no banco de dados mysql!</p>
			<p>O erro encontrado foi:</p>
			<p>'.mysqli_error($GLOBALS["___mysqli_ston"]).'</p>
		');		
	}else{
		@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
		header("location:../index.php?pag=".$t."&lista=".$getLista."&o=".$geto."&buscar=".$getBuscar."&tipo=p&tipoSelect=".$tipoSelect."");
	}
	




?>