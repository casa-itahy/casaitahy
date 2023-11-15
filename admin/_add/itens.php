<?php 
    include_once("php/sessao.php");
    session_write_close();
    $idiomas = query("select sigla,nome FROM idiomas WHERE status=1");
?>

	<script type="text/javascript" src="js/validation.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css" />

<script language="javascript">
function lowcase(form){
    var texto = document.getElementById('login').value;
	texto = texto.replace(' ','');
	document.getElementById('login').value = texto;
        }
</script>

<form action="_gravar/<?php echo $paginas['pag_tab_nome'] ?>.php" enctype="multipart/form-data" method="post" id="form" name="form" >

<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><h1>Incluir 
    <?php
        echo $paginas['titulo'];
        session_write_close();
    ?>
    </h1></td>
  </tr>
  
  <tr>
    <td height="15" colspan="3" align="center"></td>
  </tr>
  <tr>
    <td width="60" class="titulo_noticias">Código</td>
    <td class="titulo_noticias"><label>
       <input name="cod" type="text" id="cod" size="12" maxlength="15" class="required">
    </label></td>
  </tr>
  <tr>
      <td colspan="2" class="titulo_noticias">
          <table>
              <th colspan="<?php echo (count($idiomas)*2); ?>" style="text-align: center;" ><p style="background-color:#C5CEFA;">Nome do Item</p></th>
              <tr>
                  <?php $total_criado=0;
                        foreach($idiomas as $idioma){
                            if($total_criado==2){
                                echo '</tr><tr>';
                                $total_criado=0;
                            }
                            echo '<td class="titulo_noticias" style="font-weight: normal;">'.$idioma['nome'].'</td>
                            <td class="titulo_noticias"><label>
                                <input name="nome'.$idioma['sigla'].'" type="text" id="nome'.$idioma['sigla'].'" size="55"  class="required">
                            </label></td>';
                            $total_criado++;
                        }
                  ?>
              </tr>
          </table> 
          <br />
      </td>         
  </tr>
  <tr>
    <td colspan="3" class="titulo_noticias">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="right" class="titulo_noticias"><input type="submit" value="Salvar" class="botao_form" /></td>
  </tr>
</table>
</form>