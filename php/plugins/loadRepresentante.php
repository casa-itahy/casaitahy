<?php

	include '../../admin/includes/db.php';

	$categoria = $_POST['categoria'];

	$estados = query('SELECT DISTINCT(estados.id_estado), associados.estado, estados.sigl_estado, estados.dsc_estado FROM associados LEFT JOIN estados ON(estados.id_estado = associados.estado) WHERE associados.categoria = '.$categoria.' ORDER BY estados.sigl_estado');

	if(count($estados) > 0){
		echo '<option value="">UF</option>';
		foreach($estados as $da){
			echo '<option value="'.$da['id_estado'].'">'.$da['sigl_estado'].'</option>';
		}
	} else {
		echo '<option value="0">Selecione outro servico</option>';
	}

?>