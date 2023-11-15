<?php

include_once("../includes/db.php");
		//include_once("includes/conexao.php");

extract($_GET);

$sql = "SELECT * FROM cidades WHERE cod_estado='$estado_id' ORDER BY dsc_cidade";
$cidadesItens = query($sql);

$select='<select name="cidade" id="cidade" >
    	<option value="null">Selecione a cidade</option>';
            foreach ($cidadesItens as $itens){
                       $select.="<option value='".$itens['id_cidade']."'>".$itens['dsc_cidade']."</option>";
            }
$select.='</select>';

echo $select;

?>
