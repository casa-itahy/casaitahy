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
	$host		= "accb2021.mysql.dbaas.com.br";
	$usuario	= "accb2021";
	$senha		= "JQBraxvb86fYK";
	$banco		= "accb2021";
	
	$mysql = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $usuario, $senha, $banco));
	
	if (!$mysql) {
   		echo '
			<p>Ocorreu um problema durante a conexão com o servidor mysql!</p>
			<p>O erro encontrado foi:</p>
			<p>'.mysqli_error($mysql).'</p>
		';
	} else {
		$selDB = mysqli_select_db( $mysql, $banco);
		if (!$selDB) {
			echo '
				<p>Ocorreu um problema durante a seleção do banco de dados mysql!</p>
				<p>O erro encontrado foi :</p>
				<p>'.mysqli_error($mysql).'</p>
			';
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