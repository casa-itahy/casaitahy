<?php 
include_once("php/sessao.php");
session_write_close();

    include_once("includes/functions.php");

  $id = $_GET['id'];

  $sql = "SELECT * FROM categorias_noticias WHERE id=$id ";
  $dados = query($sql);

  $sql = "SELECT * FROM links WHERE tipo = 8 AND lin_id_pg = $id";
  $links = query($sql);

?>

<script type="text/javascript" src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<form action="_update/<?php echo $paginas['pag_tab_nome'].'.php'; ?>" enctype="multipart/form-data" method="post" id="form" >
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" >
<input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" >
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
        </h1>
    </td>
  </tr>  
  <tr>
    <td height="15" colspan="2" align="center"></td>
  </tr>
  <tr>
      <td class="titulo_noticias">T&iacute;tulo Português</td>
      <td class="titulo_noticias">
        <input name="titulo" type="text" size="55"  class="required" value="<?php echo $dados[0]['titulo']; ?>" />
      </td>
  </tr>
  <tr style="display: none;">
      <td class="titulo_noticias">T&iacute;tulo Inglês</td>
      <td class="titulo_noticias">
        <input name="titulo_ing" type="text" size="55"  class="required" value="<?php echo $dados[0]['titulo_ingles']; ?>" />
      </td>
  </tr>
  <tr style="display: none;">
      <td class="titulo_noticias">T&iacute;tulo Espanhol</td>
      <td class="titulo_noticias">
        <input name="titulo_esp" type="text" size="55"  class="required" value="<?php echo $dados[0]['titulo_espanhol']; ?>" />
      </td>
  </tr>

    <tr>
      <td colspan="2" class="titulo_noticias" align="center">
          <div style="background:#00579E; width:auto; height:auto; padding:10px 0; margin:20px 0; color:#FFF; line-height:30px;">
                Dicas para um bom posicionamento do seu site nos sites de busca: <a href="http://artwebdigital.com.br/wiki/dicas-seo/dicas-seo.pdf" style="background:#FFF; width:200px; height:30px; text-align:center; line-height:30px; display:block; margin-top:10px;" target="_blank">Dicas de Otimização</a>
      </div>
        </td>
    </tr>

    <tr>
        <td colspan="2" class="titulo_noticias">
            <table>              
                <tr>
                    <td class="titulo_noticias" width="125" style="font-weight: normal;">Title</td>
                    <td class="titulo_noticias">
                        <label>
                            <textarea name="title" id="title" cols="50" rows="3"><?php echo $links[0]['title']; ?></textarea>
                        </label>
                    </td>
                </tr>
            </table>
        </td>
    </tr>  

    <tr>
        <td colspan="2" class="titulo_noticias">
            <table>              
                <tr>
                    <td class="titulo_noticias" width="125" style="font-weight: normal;">Description</td>
                    <td class="titulo_noticias">
                        <label>
                            <textarea name="metad" id="metad" cols="50" rows="3"><?php echo $links[0]['metad']; ?></textarea>
                        </label>
                    </td>
                </tr>
            </table>
        </td>
    </tr>  
  <tr>
    <td colspan="2" align="right" class="titulo_noticias">
      <input type="submit" value="Atualizar" class="botao_form">  </td>
  </tr>
</table>
</form>

<script type="text/javascript">
  new Validation('form');
</script>