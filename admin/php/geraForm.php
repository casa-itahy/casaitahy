<?php

$num = $_GET[num];

for ($i=0; $i!=$num; $i++)
{
	$form .= "<input type='file' name='imagem[".$i."]' id='imagem[".$i."]' /><br>";
}
$form .= "<input type='hidden' id='altura' name='altura' value='500'>";
$form .= "<input type='hidden' id='largura' name='largura' value='500'>";
$form .= "<br /> <input type='submit' value='Gravar' />";

echo $form;
?>