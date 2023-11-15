<?php 

  include("php/sessao.php");
  session_write_close();
  include_once("includes/functions.php");

  $id = $_GET['id'];

  $dados = query("SELECT * FROM tags WHERE id_tag=$id");

  $texto_tag = htmlspecialchars ($dados[0]['texto_tag']);

?>

<script type="text/javascript" src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<form action="_update/tags.php" enctype="multipart/form-data" method="post" id="form" >
  <input type="hidden" id="tabela" name="tabela" value="tags">
  <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
  <input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" >
  <table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <h1>Editar <?php echo $paginas['titulo']; session_write_close(); ?></h1>
      </td>
    </tr>  
    <tr>
      <td height="15" colspan="2" align="center"></td>
    </tr>
     <tr>   
        <td class="titulo_noticias">Tag</td>
        <td class="titulo_noticias">
          <input type="text" name="tag" value="<?php echo $dados[0]['texto_tag']; ?>">
        </td>
    </tr>
    <tr>
      <td colspan="2" align="center" class="titulo_noticias">
        <input type="submit" value="Atualizar" class="botao_form" />
      </td>
    </tr>
  </table>
</form>
<script type="text/javascript">
  new Validation('form');
</script>