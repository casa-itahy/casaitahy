<?php
/**
 * upload.php
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */
include_once("../../admin/includes/db.php");
// HTTP headers for no cache etc
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Settings
//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
//$targetDir = 'uploads/';

//$cleanupTargetDir = false; // Remove old files
//$maxFileAge = 60 * 60; // Temp file age in seconds

// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Get parameters
$chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
$chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
$clientes_id = isset($_REQUEST["param1"]) ? $_REQUEST["param1"] : '';
$nome_original = $_FILES['file']['name'];

// Clean the fileName for security reasons
$fileName = preg_replace('/[^\w\._]+/', '', $fileName);

$img_pasta_albuns = query("SELECT pasta FROM clientes_docs WHERE clientes_id=".$clientes_id." AND pasta<>'' AND pasta IS NOT NULL DESC LIMIT 1 ");
        //var_dump();die();
        if(count($img_pasta_albuns)>0){
           $pasta = $img_pasta_albuns[0]['pasta'];
        }else{
           $pasta=date("dmYhis");
           mkdir("../../admin/docs_upload/".$pasta, 0777);
        }
        
        $sql="INSERT INTO docs(src,titulo,dt_upload,tipo)VALUES('$fileName','$nome_original',NOW(),3);";//3 é tipo clientes_docs
        $conn = conecta();
        $q = @mysqli_query($conn, $sql);
        $docs_id = ((is_null($___mysqli_res = mysqli_insert_id($conn))) ? false : $___mysqli_res);
        ((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
        
        $sql="INSERT INTO clientes_docs(clientes_id,docs_id,pasta) VALUES('$clientes_id','$docs_id','$pasta')";
        $conn = conecta();
        $q=@mysqli_query($conn, $sql);
        
 ############## // ##############################
 $pasta="../../admin/docs_upload/".$pasta;

// Make sure the fileName is unique but only if chunking is disabled
if ($chunks < 2 && file_exists($pasta . DIRECTORY_SEPARATOR . $fileName)) {
	$ext = strrpos($fileName, '.');
	$fileName_a = substr($fileName, 0, $ext);
	$fileName_b = substr($fileName, $ext);

	$count = 1;
	while(file_exists($pasta . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
	$count++;

	$fileName = $fileName_a . '_' . $count . $fileName_b;
}

// Look for the content type header
if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
	$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

if (isset($_SERVER["CONTENT_TYPE"]))
	$contentType = $_SERVER["CONTENT_TYPE"];

if(strpos($contentType, "multipart") !== false){
	if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])){		
		$out = fopen($pasta . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
		if($out){                        
			
			$in = fopen($_FILES['file']['tmp_name'], "rb");
			if($in){ 
                           ini_set('memory_limit', '100M'); 
                            
                           $str_file = $_FILES['file']['tmp_name'];
                           $arquivo=$_FILES['file'];
                           $local_salva=$pasta.DIRECTORY_SEPARATOR.$fileName;        
                           //list($width, $height) = getimagesize($str_file);                           
                           if(!move_uploaded_file($str_file, $local_salva)){                               
                               
                           }else{         
                            /*$source_pic = $local_salva; //'images/source.jpg';
                            $destination_pic = $pasta.DIRECTORY_SEPARATOR.'destination2.jpg';
                            $max_width = 500;
                            $max_height = 500;

                            $src = imagecreatefromjpeg($source_pic);
                            list($width,$height)=getimagesize($source_pic);

                            $x_ratio = $max_width / $width;
                            $y_ratio = $max_height / $height;

                            if( ($width <= $max_width) && ($height <= $max_height) ){
                                $tn_width = $width;
                                $tn_height = $height;
                                }elseif (($x_ratio * $height) < $max_height){
                                    $tn_height = ceil($x_ratio * $height);
                                    $tn_width = $max_width;
                                }else{
                                    $tn_width = ceil($y_ratio * $width);
                                    $tn_height = $max_height;
                            }

                            $tmp=imagecreatetruecolor($tn_width,$tn_height);
                            imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);

                            imagejpeg($tmp,$destination_pic,100);
                            imagedestroy($src);
                            imagedestroy($tmp);
                            */
                           }
                           
                           
                        }else
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                
                        fclose($in);
			fclose($out);
			//@unlink($_FILES['file']['tmp_name']);
                  } else
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}'); 
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
} else {
	// Open temp file
	$out = fopen($pasta . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
	if ($out) {
		// Read binary input stream and append it to temp file
		$in = fopen("php://input", "rb");
		if($in){
			while ($buff = fread($in, 4096))
				fwrite($out, $buff);
		}else
			die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

		fclose($in);
		fclose($out);
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

// Return JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');

?>