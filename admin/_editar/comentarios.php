<?php 
include("php/sessao.php");

$id = $_GET[id];

$sql = "SELECT * FROM recados WHERE id = '$id'";
$dados = query($sql);

$titulo = htmlspecialchars ($dados[0]['titulo']);
$nome = htmlspecialchars ($dados[0]['autor']);
$email = htmlspecialchars ($dados[0]['email']);
$recado = htmlspecialchars ($dados[0]['recado']);
$status = htmlspecialchars ($dados[0]['status']);


$tipoSelect = $_GET['tipoSelect'];

?>
	<script type="text/javascript" src="js/validation.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css" />

<form action="_update/recados.php" enctype="multipart/form-data" method="post" id="form" >
<input type="hidden" id="tabela" name="tabela" value="recados" >
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" >
<input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" >
<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><h1>Editar Recados</h1></td>
  </tr>
  
  <tr>
    <td height="15" colspan="2" align="center"></td>
  </tr>  
  <tr>
    <td width="119" class="titulo_noticias">Nome</td>
    <td width="817" class="titulo_noticias"><label>
            <input name="nome" type="text" id="nome" size="55"  value="<?php echo $nome; ?>" readonly="readonly" style="color: #797c80;">
    </label></td>
  </tr>
  <tr>
    <td width="119" class="titulo_noticias">E-mail</td>
    <td width="817" class="titulo_noticias"><label>
      <input name="email" type="text" id="email" size="55"   value="<?php echo $email; ?>" readonly="readonly" style="color: #797c80;">
    </label></td>
  </tr>
  <tr>
    <td width="119" class="titulo_noticias">T&iacute;tulo</td>
    <td width="817" class="titulo_noticias"><label>
      <input name="titulo" type="text" id="titulo" size="55"   value="<?php echo $titulo; ?>">
    </label></td>
  </tr>
  <tr>
    <td colspan="2" class="titulo_noticias">Chamada</td>
  </tr>
  <tr>
    <td colspan="2" class="titulo_noticias">
	<textarea name="texto_curto" id="texto_curto" cols="95" rows="5"><?php echo $dados[0]['recado']; ?></textarea>
    </td>
  </tr>  
  <tr>
    <td colspan="2" align="right" class="titulo_noticias">
    	<div style="width:50%; height:30px; float:left">
        	Vis&iacute;vel&nbsp;
            <?php if ($status == 1){ ?>
        	<a href="php/desativar.php?id=<?php echo $id ?>&amp;v=0&amp;t=32&tipoSelect=<?php echo $tipoSelect?>"><img src="img/olho_visivel.gif" alt="Ativar" border="0"></a>
			<?php } else { ?>
            <a href="php/desativar.php?id=<?php echo $id ?>&amp;v=1&amp;t=32&tipoSelect=<?php echo $tipoSelect?>"><img src="img/olho_oculto.gif" alt="Ativar" border="0"></a>
            <?php } ?>
        </div>
        <div style="width:50%; height:30px; float:right"><input type="submit" value="Atualizar" class="botao_form">	</div>
    </td>
  </tr>
</table>
</form>
	<script type="text/javascript">
        new Validation('form');
    </script>