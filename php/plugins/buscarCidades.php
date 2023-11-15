<?php

	include_once('../../admin/includes/db.php');
	
	$id_estado = $_POST['estado'];
	
	if (is_numeric($id_estado)) {
		
		$cidades = query("SELECT * FROM cidades WHERE cod_estado = ".$id_estado);
		
		$html = "";
		foreach ($cidades as $cd) {
			$html .= "<option value=".$cd['id_cidade']." >".$cd['dsc_cidade']."</option>";
		}
		
	} else {
		$sql = "SELECT id_estado FROM estados WHERE sigl_estado = '".$id_estado."'";
		$id_agora = query($sql);
		 
		$cidades = query("SELECT * FROM cidades WHERE cod_estado = ".$id_agora['0']['id_estado']);
		
		$html = "";
		foreach ($cidades as $cd) {
			$html .= "<option value='".$cd['dsc_cidade']."' >".$cd['dsc_cidade']."</option>";
		}
		
	}
	echo $html;

?>