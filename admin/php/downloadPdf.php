<?php

if(isset($_GET['docs'])){    
        $url="../docs_upload/catalogo/".$_GET['file'];
}else 
    $url="../docs_upload/".$_GET['file'];


if(isset($_GET['n']))
    $nome=$_GET['n'];
else
    $nome=$_GET['file'];

header("Content-type:application/pdf");
// It will be called downloaded.pdf
header("Content-Disposition:attachment;filename=".$nome);
// The PDF source is in original.pdf

readfile($url);

?>
