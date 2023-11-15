<?php 

include("../php/class.upload.php");
include("../php/sessao.php");
session_write_close();
extract($_POST);

if(count($_FILES) > 0)
{

$destino = "../imagens/$album";


/*---------------------------------------------------------*/
$files = array();

foreach ($_FILES['imagem'] as $k => $l) {
  foreach ($l as $i => $v) {
	 if (!array_key_exists($i, $files)) 
		 $files[$i] = array();
	  $files[$i][$k] = $v;
  }
}

foreach ($files as $file) 
{  
	$handle = new Upload($file);

    if ($handle->uploaded) 
	{  
		$num = date("dmYhis");
		$handle->image_resize = true;
		$handle->image_ratio_x = false;    
		$handle->image_ratio_y = true;
	    $handle->image_x = 540;
      	$handle->file_name_body_add =$num;
		$handle->Process($destino);
		
	
		$handle->image_resize = true;
		$handle->image_ratio_y = false;
		$handle->image_x = 100;
		$handle->image_y = 75;
		$handle->image_contrast = 10;
		$handle->jpeg_quality = 70;
		$handle->file_name_body_add = $num;
		$handle->Process($destino."/thumb");	
	}
	
	$handle-> Clean();
	
}
}
header("Location:../index.php?pag=6&msg=".$msg." ");
?>