<?php 
include_once("sessao.php");
include_once('../includes/db.php');

$action 				= $_POST['action']; 
$updateRecordsArray 	= $_POST['recordsArray'];

if ($action == "updateRecordsListings"){
	
	$listingCounter = 1;

	foreach ($updateRecordsArray as $recordIDValue) {
		
		$conn = conecta();
		$query = "UPDATE plano_individual SET posicao = ".$listingCounter." WHERE id = ".$recordIDValue;
		//mysql_query($query) or die('Error, insert query failed');
		mysqli_query($conn, $query);
		$listingCounter = $listingCounter + 1;	
	}
	/*
	echo '<pre>';
	print_r($updateRecordsArray);
	echo '</pre>';
	*/
}

var_dump($updateRecordsArray);

?>