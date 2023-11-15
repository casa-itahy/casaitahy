<?php

	function retira_acentos($frase) {
	    $frase = preg_replace("[^a-zA-Z0-9_.]", "", strtr($frase, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ","aaaaeeiooouucAAAAEEIOOOUUC_"));
	    return $frase;
	}

	// Getting file name
	$filename = $_FILES['file']['name'];

	// file type
	$filetype = $_POST['filetype'];

	// Valid extension
	if($filetype == 'media'){
		$valid_ext = array('mp4','mp3');
	}
	if($filetype == 'image'){
		$valid_ext = array('png','jpeg','jpg');
	}

	// Location
    $name = retira_acentos(ucwords(strtolower($filename)));
	$location = "imagens/editor/".$name;

	// file extension
	$file_extension = pathinfo($location, PATHINFO_EXTENSION);
	$file_extension = strtolower($file_extension);

	$return_filename = "";

	// Check extension
	if(in_array($file_extension,$valid_ext)){
		// Upload file
		if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
		    $return_filename = $name;
		}
	}

	echo $return_filename;