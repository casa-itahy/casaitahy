<?php 
include_once("php/sessao.php");

if($_SESSION['pag_atual_nome']!='itens'){
    session_write_close();
    header('Location: ../index.php');
    exit;
}else{
session_write_close();
$id = $_GET['id'];

$sql = "(SELECT i.nome, i.sigla,id.descricao FROM idiomas i 
            LEFT JOIN itens_idioma id ON(i.id=id.idioma_id)
        WHERE i.status=1 AND id.itens_id=$id ORDER BY i.id)
        UNION ALL
        (SELECT i.nome, i.sigla,null
            FROM idiomas i
            WHERE i.status=1 AND i.id!=1
               AND id NOT IN (SELECT idioma_id FROM itens_idioma WHERE itens_id=$id)
            ORDER BY i.id)";




//var_dump($sql);die();
$dados_idioma = query($sql);


$sql = "SELECT * FROM itens WHERE id=$id";
$itens = query($sql);


$nome_item=$itens[0]['descricao'];

?>
<script type="text/javascript" src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<script language="javascript">
function lowcase(form){
    var texto = document.getElementById('nome').value;
	texto = texto.replace(' ','');
	document.getElementById('nome').value = texto;
        }
</script>

<form action="_update/<?php echo $paginas['pag_tab_nome']; ?>.php" enctype="multipart/form-data" method="post" id="form" name="form" >
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" >
<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><h1>Editar 
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
       <input name="cod" type="text" id="cod" size="12" maxlength="15"  class="required" value="<?php echo $itens[0]['cod']; ?>">
    </label></td>
  </tr>
  <tr>
      <td colspan="2" class="titulo_noticias">
          <div style="background-color:#C5CEFA; width: 100%; text-align: center;">Nome completo</div>
              <table>              
                  <tr>
                      <?php echo '<td class="titulo_noticias" style="font-weight: normal; ">Português</td>
                                <td class="titulo_noticias"><label>
                                    <input name="nome'.Port.'" type="text" id="nome'.Port.'" size="55"  class="required" value="'.$nome_item.'" />
                                </label></td>';
                            if(count($dados_idioma)>0){
                                foreach($dados_idioma as $idioma){
                                    $nome = $idioma['nome'];
                                    $sigla=$idioma['sigla'];
                                    $nome_item=$idioma['descricao'];

                                    echo '<td class="titulo_noticias" style="font-weight: normal;">'.$nome.'</td>
                                    <td class="titulo_noticias"><label>
                                        <input name="nome'.$sigla.'" type="text" id="nome'.$sigla.'" size="55"  class="required" value="'.$nome_item.'" />
                                    </label></td>';
                                }
                            }else{
                                echo monta_input($idiomas, 'titulo');
                            }
                      ?>
                  </tr>
              </table>
           <br />
      </td>       
  </tr> 
  <tr>
    <td colspan="3" align="right" class="titulo_noticias">
      <input type="submit" value="Salvar" class="botao_form">	</td>
  </tr>
</table>
</form>
<?php } ?>