<?php

function imagemVideo($url){
	$url_imagem = parse_url($url);
	if ($url_imagem['host'] == 'www.youtube.com' || $url_imagem['host'] == 'youtube.com') {
		$array = explode("&", $url_imagem['query']);
		$imagemVideo = "http://img.youtube.com/vi/".substr($array[0], 2)."/0.jpg";
	} else if ($url_imagem['host'] == 'www.vimeo.com' || $url_imagem['host'] == 'vimeo.com') {
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".substr($url_imagem['path'], 1).".php"));
		$imagemVideo = $hash[0]["thumbnail_small"];
	}
	return $imagemVideo;
}

function idVideo($url){
	$ex = explode("=",$url);
	$idVideo = $ex[1];

	$explode = explode("&", $ex[1]);
	$idVideo = $explode[0];

	return $idVideo;
}

function formataData($data) {
	$meses = array('','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
	$x = explode('-', $data); 
	$d = explode(' ', $x['2']);
	
	$dataCorreta = $d['0']." de ".$meses[abs($x['1'])]." de ".$x['0'];
	
	return $dataCorreta;
}

//data no formato 16/04/2012
function formataDataNum($data) {
	
	
	$x = explode('-', $data);
	$dataNum = $x['2']."/".$x['1']."/".$x['0'];
	
	return $dataNum;
}

function trocaIDestado($idA){
switch($idA){
		case 1:
		$estado = 21;	break;
		case 2:
		$estado = 24;	break;
		case 3:
		$estado = 16;	break;
		case 4:
		$estado = 25;	break;
		case 5:
		$estado = 19;	break;
		case 6:
		$estado = 8;	break;
		case 7:
		$estado = 13;	break;
		case 8:
		$estado = 12;	break;
		case 9:
		$estado = 9;	break;
		case 10:
		$estado = 7;	break;
		case 11:
		$estado = 5;	break;
		case 12:
		$estado = 26;	break;
		case 13:
		$estado = 2;	break;
		case 14:
		$estado = 17;	break;
		case 15:
		$estado = 15;	break;
		case 16:
		$estado = 20;	break;
		case 17:
		$estado = 6;	break;
		case 18:
		$estado = 18;	break;
		case 19:
		$estado = 10;	break;
		case 20:
		$estado = 27;	break;
		case 21:
		$estado = 11;	break;
		case 22:
		$estado = 14;	break;
		case 23:
		$estado = 3;	break;
		case 24:
		$estado = 22;	break;
		case 25:
		$estado = 4;	break;
		case 26:
		$estado = 23;	break;
		case 27:
		$estado = 1;	break;
	}
	return $estado;
}

function anti_sql($texto){
	// Lista de palavras para procurar
	$check[1] = chr(34); // s�mbolo "
	$check[2] = chr(39); // s�mbolo '
	$check[3] = chr(92); // s�mbolo /
	$check[4] = chr(96); // s�mbolo `
	$check[5] = "drop table";
	$check[6] = "update";
	$check[7] = "alter table";
	$check[8] = "drop database";	
	$check[9] = "drop";
	$check[10] = "select";
	$check[11] = "delete";
	$check[12] = "insert";
	$check[13] = "alter";
	$check[14] = "destroy";
	$check[15] = "table";
	$check[16] = "database";
	$check[17] = "union";
	$check[18] = "TABLE_NAME";
	$check[19] = "1=1";
	$check[20] = 'or 1';
	$check[21] = 'exec';
	$check[22] = 'INFORMATION_SCHEMA';
	$check[23] = 'like';
	$check[24] = 'COLUMNS';
	$check[25] = 'into';
	$check[26] = 'VALUES';
	
	// Cria se as vari�veis $y e $x para controle no WHILE que far� a busca e substitui��o
	$y = 1;
	$x = sizeof($check);
	// Faz-se o WHILE, procurando alguma das palavras especificadas acima, caso encontre alguma delas, este script substituir� por um espa�o em branco " ".
	while($y <= $x){
		   $target = strpos($texto,$check[$y]);
			if($target !== false){
				$texto = str_replace($check[$y], "", $texto);
			}
		$y++;
	}
	// Retorna a vari�vel limpa sem perigos de SQL Injection
	return $texto;
} 
#-----------------------------------------------------------------------------------#
function geraTotal()
{
	session_start();

	foreach ($_SESSION['cesta'] as $sessao)	
	{
		$total = formataReais($total, $sessao['totalitem'], "+");		
	}

	$_SESSION['totalgeral'] = $total;

	session_write_close();
}
#-----------------------------------------------------------------------------------#
function formataReais($valor1, $valor2, $operacao)
{
	$valor1 = str_replace (",", "", $valor1);
	$valor2 = str_replace (",", "", $valor2);   
    $valor1 = str_replace (".", "", $valor1);
    $valor2 = str_replace (".", "", $valor2);

    switch ($operacao) {
        case "+":
            $resultado = $valor1 + $valor2;
            break;

        case "-":
            $resultado = $valor1 - $valor2;
            break;

        case "*":
            $resultado = $valor1 * $valor2;
            break;
    } 

    $len = strlen ($resultado);

    switch ($len) {
        case "2":
            $retorna = "0,$resultado";
            break;

        case "3":
            $d1 = substr("$resultado",0,1);
            $d2 = substr("$resultado",-2,2);
            $retorna = "$d1,$d2";
            break;

        case "4":
            $d1 = substr("$resultado",0,2);
            $d2 = substr("$resultado",-2,2);
            $retorna = "$d1,$d2";
            break;

        case "5":
            $d1 = substr("$resultado",0,3);
            $d2 = substr("$resultado",-2,2);
            $retorna = "$d1,$d2";
            break;

        case "6":
            $d1 = substr("$resultado",1,3);
            $d2 = substr("$resultado",-2,2);
            $d3 = substr("$resultado",0,1);
            $retorna = "$d3.$d1,$d2";
            break;

        case "7":
            $d1 = substr("$resultado",2,3);
            $d2 = substr("$resultado",-2,2);
            $d3 = substr("$resultado",0,2);
            $retorna = "$d3.$d1,$d2";
            break;

        case "8":
            $d1 = substr("$resultado",3,3);
            $d2 = substr("$resultado",-2,2);
            $d3 = substr("$resultado",0,3);
            $retorna = "$d3.$d1,$d2";
            break;

    } 

    return $retorna;
}

//funcao para limitar texto
function limita($frase, $comeco, $fim, $caracter) {
	
	$limita = substr($frase, $comeco, $fim)." $caracter";
	
	
	return $limita;
	
}

//funcão para chamar imgem que esta no editor de textos
function pegaImg($texto) {

	$pegaPasta = "/".$raiz[1]."/admin";
	
	$newText = str_replace("admin", $pegaPasta, $texto);
	
	return $newText;

}

function limita_caracteres($texto, $limite, $quebra = true) {
$tamanho = strlen($texto);

if ($tamanho <= $limite) {
	$novo_texto = $texto;
	} else {
		if ($quebra == true) {
			$novo_texto = trim(substr($texto, 0, $limite)).'...';
		} else {
			$ultimo_espaco = strrpos(substr($texto, 0, $limite), ' ');
			$novo_texto = trim(substr($texto, 0, $ultimo_espaco)).'...';
		}
	}
	return $novo_texto;
}

function is_mobile(){
	$mobile_browser = '0';
	if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		$mobile_browser++;
	} 

	if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or
	 ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
		$mobile_browser++;
	}
 
	$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
	$mobile_agents = array(
		'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
		'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
		'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
		'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
		'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
		'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
		'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
		'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
		'wapr','webc','winw','winw','xda','xda-');
	 
	if(in_array($mobile_ua,$mobile_agents)) {
		$mobile_browser++;
	}

	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
		$mobile_browser++;
		//Check for tablets on opera mini alternative headers
		$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
		if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
		  $mobile_browser++;
		}
	} 

	if (strstr($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
		$mobile_browser++;
	}

	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'OperaMini')>0) {
		$mobile_browser++;
	}
 
	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0) {
		$mobile_browser=0;
	}
 
	return (bool) $mobile_browser > 0;
}

function imagemEditor($texto){
	$texto = str_replace("imagens/editor/", "admin/imagens/editor/", $texto);

	return $texto;
}

function selected($str1,$str2){
	if(!strcmp($str1,$str2)){
		echo 'selected="selected"';
	}
}