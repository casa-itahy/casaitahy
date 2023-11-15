<?php 
include("class.upload.php");

function ultimaPosicao($tabela)
{
	$sql = "SELECT MAX(posicao) FROM $tabela";
	$resultado = query($sql);
	$posicao = $resultado[0]['MAX(posicao)'];
	if ($posicao == 0)
	{
		$posicao = 1;
	}

	return $posicao;
}

function primeiraPosicao($tabela)
{
	$sql = "SELECT MIN(posicao) FROM $tabela";
	$resultado = query($sql);
	$posicao = $resultado[0]['MIN(posicao)'];
	if ($posicao == 0){
		$posicao = 1;
	}
	return $posicao;
}

# Função que redimensiona e grava imagens #
function gravaImagem($imagem, $pasta, $tam_principal, $tam_thumb, $orientacao){
	
    $handle = new Upload($imagem);
    
	if ($handle->uploaded) {
		$destino = "../imagens/$pasta";
		$nome = date("dmYhis");
		
		$largura = $handle->image_src_x;
		$altura = $handle->image_src_y; 

		# Orientar pela maior dimensão #
		if (strtoupper($orientacao) == 'M') {
			if ($largura > $altura){
				$orientacao = 'H';
			} else {
				$orientacao = 'V';
			}
		}
		
        switch (strtoupper($orientacao)) {        	
        	case 'V':
        		#Thumb vertical#
        		if ($altura > $tam_thumb) {
        			$handle->image_resize = true;
        		} else {
        			$handle->image_resize = false;
        		}
        		
        		$handle->file_new_name_body	= "thumb_".$nome;
				$handle->image_y			= $tam_thumb;
				$handle->image_ratio_x      = true;
				$handle->Process($destino);
				
				#Principal Vertical#
				if ($altura > $tam_principal) {
        			$handle->image_resize = true;
        		} else {
        			$handle->image_resize = false;
        		}
        		
        		$handle->file_new_name_body	= $nome;
				$handle->image_y			= $tam_principal;
				$handle->image_ratio_x      = true;
				$handle->mime_check 		= true;
				$handle->Process($destino);
				$foto_principal = $handle->file_dst_name;
				break;
				
        	case 'H':
        		#Thumb Horizontal#
        		if ($largura > $tam_thumb) {
        			$handle->image_resize = true;
        		} else {
        			$handle->image_resize = false;
        		}
        		
        		$handle->file_new_name_body	= "thumb_".$nome;
				$handle->image_x			= $tam_thumb;
				$handle->image_ratio_y      = true;
				$handle->Process($destino);
				
				#Principal Vertical#
				if ($largura > $tam_principal) {
        			$handle->image_resize = true;
        		} else {
        			$handle->image_resize = false;
        		}
        		
        		$handle->file_new_name_body	= $nome;
				$handle->image_x			= $tam_principal;
				$handle->image_ratio_y      = true;
				$handle->mime_check 		= true;
				$handle->Process($destino);
				$foto_principal = $handle->file_dst_name;
				break;
        	
        	case 'N':        		
        		#Thumb Horizontal#
        		if ($largura > $tam_thumb) {
        			$handle->image_resize = true;
        		} else {
        			$handle->image_resize = false;
        		}
        		
        		$handle->file_new_name_body	= "thumb_".$nome;
				$handle->image_x			= $tam_thumb;
				$handle->image_ratio_y      = true;
				$handle->Process($destino);
				
        		#Sem redimensionamento#
        		$handle->image_resize 		= false;        		
        		$handle->file_new_name_body	= $nome;
        		$handle->mime_check 		= true;
				$handle->Process($destino);
				$foto_principal = $handle->file_dst_name;
				break;
				
        	default:
        		$foto_principal = false;			
        		break;
        }

        $handle-> Clean();    

    	return $foto_principal;
    }
    
    
}

//formatar data para dd/mm/yy as hh:mm
function formataData($data, $separador) {
	
	//separando data da hora
	$explodeData = explode(' ', $data);
	
	$dataSeparada = $explodeData[0];
	
	//organizando a data para o fomato brasileiro
	$dataBr = explode('-', $dataSeparada);
	
	$ano = $dataBr[0];
	$mes = $dataBr[1];
	$dia = $dataBr[2];
	
	//nova data
	$novadata = $dia.$separador.$mes.$separador.$ano;
	$hora =  $explodeData[1];
	
	$dataHora = $novadata." ás ".$hora;
	
	return $dataHora;
	
}

function limita($frase, $comeco, $fim, $caracter) {
	
	$limita = substr($frase, $comeco, $fim)." $caracter";
	
	
	echo $limita;
	
}

?>