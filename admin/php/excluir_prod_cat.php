<?php 

@session_start();
$nivel = $_SESSION['nivel'];
@session_write_close();

include_once("../includes/db.php");

$id = $_GET['id'];
$t = $_GET['t'];

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
				
				//verrificando se existe subcategoria filho e se não existe a subcategoria neto
				if($filho != 'NULL' and $neto == 'NULL') {
					
					//VERIFICA SE EXISTE ALGUM PRODUTO CADASTRADO COM ESTA SUBCATEGORIA(FILHO)
					$sqlExiste = "SELECT id FROM produtos WHERE categoria_id='$filho' LIMIT 1;";
					$produto = query($sqlExiste);
					if(count($produto)>0){
						$msg='Não foi possível excluir o registro, apague os produtos vinculados a esta subcategoria';
						header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
						die();
					
					//se não existir produtos cadastrados nesta subcategoria continua o script...
					}else{
						
						//agora vai verrificar se esta subcategoria possui outra subcategoria (NETO)
						$verrificaSubNeto = "SELECT cat_neto_id FROM cat_subcat_nivel WHERE cat_filho_id = '$filho'";
						$execVerSubNeto = query($verrificaSubNeto);
						if($execVerSubNeto[0][cat_neto_id] > 0) {
							$msg='Não foi possível excluir o registro, apague a subcategoria';
							header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
							die();
						
						//se não possuir categoria neto...
						}else{
							
							$conn = conecta();
							
							$apagaFilho = "DELETE FROM categorias_subcat WHERE id = '$filho'";
							$apagaOutros = "DELETE FROM cat_subcat_nivel WHERE cat_filho_id = '$filho'";
							//executando
							$execApaFilho = mysqli_query( $conn, $apagaFilho);
							$execApaOutros = mysqli_query( $conn, $apagaOutros);
							
							if($execApaFilho) {
								if($execApaOutros) {
									$msg='Subcategoria deletada com sucesso';
									header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
									die();
								}else{
									$msg='Não foi possivel deletar a subcategoria';
									header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
									die();
								}
							}else{
								$msg='Não foi possivel deletar a subcategoria';
								header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
								die();
							}

						}
					}
					
				//verrificando se existe a subcategoria neto (se foi clicado para deletar ela)
				}elseif($filho != 'NULL' and $neto != 'NULL') {
					//veriificando se existe produtos cadastrados na subcategoria neto
					$verrificaProNeto = "SELECT id FROM produtos WHERE categoria_id='$neto' LIMIT 1;";
					$execProNeto = query($verrificaProNeto);
					if(count($execProNeto)>0){
						$msg='Não foi possível excluir o registro, apague os produtos vinculados a esta subcategoria';
						header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
						die();
					
					//se não existir produtos cadastrados nesta subcategoria vamos apager ela...
					}else{
						
						$conn = conecta();
							
						$apagaNeto = "DELETE FROM categorias_subcat WHERE id = '$neto'";
						$apagaOutrosNeto = "DELETE FROM cat_subcat_nivel WHERE cat_neto_id = '$neto'";
						//executando
						$execApaNeto = mysqli_query( $conn, $apagaNeto);
						$execApaOutrosNeto = mysqli_query( $conn, $apagaOutrosNeto);
						
						if($execApaNeto) {
							if($execApaOutrosNeto) {
								$msg='Subcategoria deletada com sucesso';
								header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
								die();
							}else{
								$msg='Não foi possivel deletar a subcategoria';
								header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
								die();
							}
						}else{
							$msg='Não foi possivel deletar a subcategoria';
							header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
							die();
						}
						
					}
				
				//caso nao tenha filho nem neto...
				}elseif($filho == 'NULL' and $neto == 'NULL') {
					
					//verrificando se tem produtos na categoria
					$verrificaPro = "SELECT id FROM produtos WHERE categoria_id='$idpai' LIMIT 1;";
					$execPro = query($verrificaPro);
					
					if(count($execPro)>0){
						$msg='Não foi possível excluir o registro, apague os produtos vinculados a esta categoria';
						header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
						die();
					
					//se não existir produtos cadastrados nesta subcategoria continua o script...
					}else{
						
						//verrificando se existe categoria filho
						$verrificaPaternidade = "SELECT cat_filho_id FROM cat_subcat_nivel WHERE cat_pai_id = '$idpai' ";
						$execPaternidade = query($verrificaPaternidade);
						
						if($execPaternidade[0]['cat_filho_id'] > 0) {
							$msg='Não foi possível excluir o registro, apague as subcategorias';
							header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
							die();
						}else{
							
							$conn = conecta();
							
							$apagaCat = "DELETE FROM categorias_subcat WHERE id = '$idpai'";
							$apagaOutrosCat = "DELETE FROM cat_subcat_nivel WHERE cat_pai_id = '$idpai'";
							//executando
							$execApaCat = mysqli_query( $conn, $apagaCat);
							$execApaOutrosCat = mysqli_query( $conn, $apagaOutrosCat);
							
							if($execApaCat) {
								if($execApaOutrosCat) {
									$msg='Categoria deletada com sucesso';
									header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
									die();
								}else{
									$msg='Não foi possivel deletar a categoria';
									header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
									die();
								}
							}else{
								$msg='Não foi possivel deletar a categoria';
								header ("Location:../index.php?pag=".$t."&tipo=p&msg=".$msg." ");
								die();
							}
							
						}
					}
				}



?>