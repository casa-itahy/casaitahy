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

?>
<script type="text/javascript">
	function geraForm(){
		var num = document.getElementById('numImg').value;
		if (num > 0)
		{
		var url = 'php/geraFormEnq.php?num='+num;
		var myAjax = new Ajax.Updater( 
		'div',
		url,{method:'post'});
		}	
	}
        function limpaForm(){
		document.getElementById('numImg').options[0].selected=true;
		document.getElementById('div').innerHTML = "<br /><a style='padding-left:5%;' href='#' onclick='geraForm();'><img src='img/ok16.png' alt='Gerar campos' width='16' height='16' border='0' ><span style='color:#006A01;'>Gerar</span></a>";
	}
</script>

	<script type="text/javascript" src="js/prototype.js"></script>
	<script type="text/javascript" src="js/validation.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css" />

<form action="_gravar/enquete.php" enctype="multipart/form-data" method="post" id="form" >
<input type="hidden" id="tabela" name="tabela" value="enquete" >

<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
	<h1>Incluir 
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
							<input name="pergunta" type="text" id="pergunta" size="55"  class="required">
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
        <span class="valor_prod">N&deg; de Respostas
            <select name="numImg" id="numImg" class="validate-number">
                <?php
                    for ($x=0;$x<=5;$x++){
                        echo "<option value='$x'> $x </option>";
                    }
                ?>
            </select>
            <a href="#" onclick="limpaForm();" ><img src="img/eraser16.png" alt="limpar campos" width="16" height="16" border="0" >Limpar</a>
        </span>
        <div id="div"><br /><a style="padding-left:5%;" href="#" onclick="geraForm();" ><img src="img/ok16.png" alt="Gerar campos" width="16" height="16" border="0" ><span style="color:#006A01;">Gerar</span></a></div>
    </td>
  </tr>
  <tr>
    <td colspan="2" class="titulo_noticias"><hr style="width: 100%"/></td>
  </tr>
  <tr>
    <td colspan="2" align="right" class="titulo_noticias">
      <input type="submit" value="Incluir" class="botao_form">	</td>
  </tr>
</table>
</form>
	<script type="text/javascript">
        new Validation('form');
    </script>