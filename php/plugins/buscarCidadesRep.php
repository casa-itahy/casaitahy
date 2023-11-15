<?php

	include_once('../../admin/includes/db.php');
	
	$id_estado = $_POST['estado'];
	$id_categoria = $_POST['categoria'];

	$cidades = query('	SELECT DISTINCT(cidades.id_cidade), associados.cidade 
						FROM associados LEFT JOIN cidades ON(cidades.id_cidade = associados.cidade) 
						WHERE cidades.cod_estado = '.$id_estado.' AND associados.categoria = '.$id_categoria.' ORDER BY cidades.dsc_cidade');

	$html = "<option value='0'>Cidade</option>";
	foreach ($cidades as $cd) {
		$nomeE = query('SELECT * FROM cidades WHERE id_cidade = '.$cd['id_cidade']);

		$html .= "<option value=".$cd['id_cidade']." >".$nomeE[0]['dsc_cidade']."</option>";
	}
		
	echo $html;

?>