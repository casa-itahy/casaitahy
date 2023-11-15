<script type="text/javascript">

setTimeout(function() {
                $('#statusAtualiza').fadeOut();}, 4000);
			

</script>
<?php 
include("../php/sessao.php");
include("../includes/db.php");
include ("../php/funcoes.php");


	//$idAlbum = $_GET['idAlbum'];
	//$idImg = $_GET['idImg'];
	//$newText = $_GET['newText'];
	
	$idImg = $_POST['idImgm'];
	$newText = $_POST['nText'];
	
	
	$conn = conecta();
	$sql = "UPDATE img_pasta_albuns SET legenda='$newText' WHERE id=".$idImg;
    $q = mysqli_query($conn, $sql);

	if($q) {
		
		echo "<div id='mens' style='margin-top;23px; color:#FFF'>Alteração efetuada com sucesso</div>";
	}else{
		echo "<div id='mens'>Deculpe, ocorreu um erro</div>";
	}
	
	
?>