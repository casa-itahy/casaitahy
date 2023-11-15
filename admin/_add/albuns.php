<?php 
    include("php/sessao.php");
    session_write_close();
                  
    $idiomas = query("select sigla,nome FROM idiomas WHERE status=1");                 
    $clientes = query("select id,nome FROM clientes WHERE status=1"); 

    $categorias = query("SELECT * FROM categorias_noticias ORDER BY titulo ASC");

?>

<!-- Mudar a data -->
<link rel="stylesheet" type="text/css" href="css/jquery.ui.all.css"/>
<link rel="stylesheet" type="text/css" href="css/jquery.ui.datepicker.css"/>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker.js"></script>

<script type="text/javascript">
    jQuery(function($){
        $("#datepicker").datepicker({  
            dateFormat: 'dd/mm/yy',
            monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'] ,
            dayNamesMin: ['D','S', 'T', 'Q', 'Q', 'S', 'S'],
            nextText: '>',
            prevText: '<'
        }); 
    });
</script>
<!-- Mudar a data -->

	<script type="text/javascript" src="js/validation.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css" />

<form action="_gravar/albuns.php" enctype="multipart/form-data" method="post" id="form" >
<input type="hidden" id="tabela" name="tabela" value="albuns" >
<input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" >
<table width="900" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><h1>Incluir 
        <?php
            echo $paginas['titulo'];
                session_write_close();
	?>    
        </h1>
    </td>
  </tr>
  <tr>
      <td colspan="2" class="titulo_noticias">
          <table>
              <th colspan="<?php echo (count($idiomas)*2); ?>" style="text-align: center;" ><p style="background-color:#C5CEFA;">T&iacute;tulo</p></th>
              <tr>
                  <?php $total_criado=0;
                        foreach($idiomas as $idioma){
                            if($total_criado==2){
                                echo '</tr><tr>';
                                $total_criado=0;
                            }
                      
                            echo '<td class="titulo_noticias" style="font-weight: normal;">'.$idioma['nome'].'</td>
                                    <td class="titulo_noticias"><label>
                                        <input name="titulo'.$idioma['sigla'].'" type="text" id="titulo'.$idioma['sigla'].'" size="55"  class="required">
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
        <td colspan="2" class="titulo_noticias">
            <br />
            <table>              
                <tr>
                    <td class="titulo_noticias" width="125" style="font-weight: normal;">Data</td>
                    <td class="titulo_noticias">
                        <input type="text" class='required' id="datepicker" size="10" name="created" />
                    </td>
                </tr>
            </table>
        </td>
        </td>
    </tr>

    <tr>
        <td colspan="2" class="titulo_noticias">
            <table>
                <tr>
                    <td class="titulo_noticias" width="125" style="font-weight: normal;">Categoria</td>
                    <td class="titulo_noticias">
                        <select name="categoria" id="categoria">
                            <option value="">Selecione</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['titulo']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>
            </table>
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
            <br />
            <table>              
                <tr>
                    <td class="titulo_noticias" width="125" style="font-weight: normal;">Title</td>
                    <td class="titulo_noticias">
                        <label>
                            <textarea name="title" id="title" cols="50" rows="3"></textarea>
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
                            <textarea name="metad" id="metad" cols="50" rows="3"></textarea>
                        </label>
                    </td>
                </tr>
            </table>
        </td>
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