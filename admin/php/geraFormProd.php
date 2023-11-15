<?php
error_reporting(0);
include_once '../includes/db.php';
$idiomas = query("select sigla,nome FROM idiomas WHERE status=1");   

$num = $_GET[num];
$tipo = $_GET[tipo];

if($tipo=='' || is_null($tipo)){
    for ($i=0; $i!=$num; $i++){
	$form .= "<br /> Imagem ".($i+1)." : <input type='file' name='imagens[".$i."]' id='imagens[".$i."]' size='30'/> Legenda: <input type='legenda' name='legenda[".$i."]' id='legenda[".$i."]' size='50' /><br>";
    }
}else{
    $form .= "<br />";
    for ($i=0; $i!=$num; $i++){
            $form .='<table border="1" width="450" class="example"><tbody><tr><td align="center">PDF '.($i+1).'</td></tr>
                    <tr><td>
                        <table border="0" width="100%" class="example_code notranslate"><tbody>';            
                            foreach($idiomas as $idioma){
                                        $form .='<tr><td width="50">Titulo: </td>
                                                     <td><input type="text" name="legenda'.$idioma['sigla'].'['.$i.']" id="legenda'.$idioma['sigla'].'['.$i.']" size="50" /></td></tr>';
                            }
                      //<tr><td width="50">Imagem: </td><td><input type="file" name="imagem['.$i.']" id="imagem['.$i.']" size="50" /></td></tr>      
             $form .='
                            <tr style="display: none;"><td width="50">Descrição: </td><td><textarea name="descricao['.$i.']" rows="4" cols="40"></textarea></td></tr>
                            <tr><td width="50">Arquivo: </td><td><input type="file" name="arquivo['.$i.']" id="arquivo['.$i.']" size="50"/></td></tr>
                            </td></tr></tbody>
                         </table>
                     </td></tr></tbody>
                    </table><br>';
    }
}

echo $form;
?>