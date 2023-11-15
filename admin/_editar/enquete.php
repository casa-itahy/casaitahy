<?php 
/**
*	ATUALIZA
*
*	@author Ari Araujo <projetos@artwebdigital.com.br>
*	@copyright GPL ? 2010, artwebdigital.com.br
*	@version ATUALIZA 3.0
*	@created 14/11/2011
*	@modified 14/11/2011
*
*/

include("php/sessao.php");
session_write_close();

$id = $_GET['id'];

	$sql = "SELECT pergunta FROM enq_perguntas WHERE id=".$id."";
	$pergunta = query($sql);
	
	
	$sql = "
		SELECT *
		FROM enq_respostas 
		WHERE id_pergunta=".$id."
	";
	$respostas = query($sql);

?>

	<script type="text/javascript" src="js/prototype.js"></script>
	<script type="text/javascript" src="js/validation.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css" />

<form action="_update/enquete.php" enctype="multipart/form-data" method="post" id="form" >
<input type="hidden" id="tabela" name="tabela" value="enquete" >
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" >

<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
	<h1>Editar 
    <?php
        echo $paginas['titulo'];
        session_write_close();
	?>
    
    </h1></td>
  </tr>
  <tr>
      <td colspan="2" class="titulo_noticias">
          <table>
              <tr>
					<td class="titulo_noticias" style="font-weight: normal;">Pergunta</td>
                    <td class="titulo_noticias">
						<label>
							<input name="pergunta" type="text" id="pergunta" size="55" value="<?php echo $pergunta['0']['pergunta']; ?>"  class="required">
						</label>
					</td>
              </tr>
          </table> 
          <br />
      </td>
  </tr>
  <tr>
    <td colspan="2" class="titulo_noticias"><hr style="width: 100%"/></td>
  </tr>
  <tr>
    <td colspan="2" align="left" class="titulo_noticias">
        <p>Respostas</p>
		<?php
			foreach ($respostas as $resp) {
				
			$qntVotos = $resp['votos'];
			if($qntVotos < 1) {
				$votos = "Nem um voto";	
			}elseif($qntVotos == 1){
				$votos = $qntVotos." Voto";	
			}else{
				$votos = $qntVotos." Votos";		
			}
		?>
		
			<input type="text" id="<?php echo $resp['id']; ?>" name="resposta[<?php echo $resp['id']; ?>]" value = "<?php echo $resp['resposta']; ?>" >
            <input type="text" value="<?php echo $votos ?>" disabled="disabled" />
			<br/>
	<?php }	?>
    </td>
  </tr>
  <tr>
    <td colspan="2" class="titulo_noticias"><hr style="width: 100%"/></td>
  </tr>
  <tr>
    <td colspan="2" align="right" class="titulo_noticias">
      <input type="submit" value="Atualizar" class="botao_form">	</td>
  </tr>
</table>
</form>
	<script type="text/javascript">
        new Validation('form');
    </script>