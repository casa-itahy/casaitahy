<?php

$num = $_GET['num'];
$form  = "";

for ($i=0; $i!=$num; $i++) {
	$n = $i+1;
	$form .= "Resposta ".$n." <input type='text' name='resposta[".$i."]' id='resposta[".$i."]' /><br>";
}

echo $form;
?>