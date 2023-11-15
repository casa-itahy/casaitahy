<?php 
		include("php/sessao.php");
                session_write_close();
				
		$idiomas = query("select sigla,nome FROM idiomas WHERE status=1");
		
		
		$id = $_GET['id'];
		
		
$sql = "SELECT * FROM noticias WHERE id=$id ";
$dados = query($sql);

?>

	<script type="text/javascript" src="js/validation.js"></script>
    
	<link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery.ui.all.css"/>
    <link rel="stylesheet" type="text/css" href="css/jquery.ui.datepicker.css"/>

	<script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.ui.core.js"></script>
	<script type="text/javascript" src="js/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="js/jquery.ui.datepicker.js"></script>
    
    <script type="text/javascript">
	var J = jQuery.noConflict();
	J(function() 
	{
		J("#datepicker").datepicker(
		{  
			dateFormat: 'dd/mm/yy',
			monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'] ,
			dayNamesMin: ['D','S', 'T', 'Q', 'Q', 'S', 'S'],
			nextText: '>',
			prevText: '<'
		});	


	});
	
	</script>

<form action="_update/agenda.php" enctype="multipart/form-data" method="post" id="form" >

<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" >
<input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" >
<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><h1>Editar Evento</h1></td>
  </tr>
  
  <tr>
    <td height="15" colspan="2" align="center"></td>
  </tr>
  <tr>
    <td width="122" class="titulo_noticias">T&iacute;tulo</td>
    <td width="814" class="titulo_noticias"><label>
      <input name="titulo" type="text" id="titulo" size="55"  class="required" value="<?php echo $dados['0']['titulo']; ?>">
    </label></td>
  </tr>
  <tr>
    <td class="titulo_noticias">Data</td>
    <td class="titulo_noticias">
		<input type="text" class='required' id="datepicker" size="10" name="data" value="<?php echo $dados['0']['descricao'];?>" >
	</td>
  </tr>
  <?php //foreach ($idiomas as $idioma) { ?>
  <tr>
    <td colspan="2" class="titulo_noticias">Detalhes</td>
  </tr>
  <tr>
    <td colspan="2" class="titulo_noticias">
		<textarea id="texto" name="texto"><?php echo $dados['0']['conteudo'];?></textarea>
		<script type="text/javascript">
			CKEDITOR.replace('texto');
		</script>
	</td>
  </tr>
  <?php // } ?>
  <tr>
    <td colspan="2" align="right" class="titulo_noticias">
      <input type="submit" value="Atualizar" class="botao_form">	</td>
  </tr>
</table>
</form>
	<script type="text/javascript">
        new Validation('form');
    </script>