<?php 
include("php/sessao.php");
session_write_close();
include_once("includes/functions.php");

$id = $_GET['id'];

$sql = "SELECT * FROM idiomas WHERE status=1 AND sigla!='Port'";
$idiomas = query($sql);

$sql = "(SELECT i.nome, i.sigla,ni.titulo,ni.descricao,ni.conteudo FROM idiomas i 
            LEFT JOIN noticias_idioma ni ON(i.id=ni.idioma_id)
        WHERE i.status=1 AND ni.noticias_id=$id ORDER BY i.id)
        UNION ALL
        (SELECT i.nome, i.sigla,null,null,null
            FROM idiomas i
            WHERE i.status=1 AND i.id!=1
               AND id NOT IN (SELECT idioma_id FROM noticias_idioma WHERE noticias_id=$id)
            ORDER BY i.id)";


//var_dump($sql);die();
$noticias_idioma = query($sql);

$sql = "SELECT * FROM noticias WHERE id=$id ";
$dados = query($sql);

$titulo = htmlspecialchars ($dados[0]['titulo']);

$atributos_itens = getAtributosItens(2); //11 páginas

?>
<script type="text/javascript" src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<form action="_update/noticias.php" enctype="multipart/form-data" method="post" id="form" >
<input type="hidden" id="tabela" name="tabela" value="noticias" >
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" >
<input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" >
<table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><h1>Editar
	<?php
            echo $paginas['titulo'];
            session_write_close();
	?>
    </h1></td>
  </tr>  
  <tr>
    <td height="15" colspan="2" align="center"></td>
  </tr>
  <?php 
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'titulo');
        if($ok!=false){
  ?>
     <tr>      
       <td colspan="2" class="titulo_noticias">
          <div style="background-color:#C5CEFA; width: 100%; text-align: center;">Pergunta</div>
          <table>              
              <tr>
                  
                  <?php echo '<td class="titulo_noticias" style="font-weight: normal; ">Português</td>
                            <td class="titulo_noticias"><label>
                                <input name="tituloPort" type="text" id="tituloPort" size="55"  class="required" value="'.$titulo.'" />
                            </label></td>';
                        if(count($noticias_idioma)>0){
                            $total_criado=1;
                            foreach($noticias_idioma as $idioma){                                
                                if($total_criado==2){
                                    echo '</tr><tr>';
                                    $total_criado=0;
                                }
                                
                                $nome = $idioma['nome'];
                                $sigla=$idioma['sigla'];
                                $titulo=$idioma['titulo'];                            

                                echo '<td class="titulo_noticias" style="font-weight: normal;">'.$nome.'</td>
                                <td class="titulo_noticias"><label>
                                    <input name="titulo'.$sigla.'" type="text" id="titulo'.$sigla.'" size="55"  class="required" value="'.$titulo.'" />
                                </label></td>';
                                
                                $total_criado++;
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
  <?php 
        }        
        //########### VERIFICA O STATUS DO ATRIBUTO ###################
        $ok = getStatusAtributo($atributos_itens,'descricao');
        if($ok!=false){
  ?>
     <tr>   
        <td colspan="2" class="titulo_noticias">
          <div style="background-color:#C5CEFA; width: 100%; text-align: center;">Resposta</div>
           <table>              
              <?php 
                    echo '<tr><td class="titulo_noticias" style="font-weight: normal;">Português</td>
                              <td class="titulo_noticias">
                                     <textarea class="editor" name="texto_curtoPort" id="texto_curtoPort" cols="90" rows="3">'.$dados[0]['descricao'].'</textarea>
                                </td></tr>';
              
                    if(count($noticias_idioma)>0){    
                        foreach($noticias_idioma as $idioma){
                            echo '<tr><td class="titulo_noticias" style="font-weight: normal;">'.$idioma['nome'].'</td>
                                  <td class="titulo_noticias">
                                         <textarea name="texto_curto'.$idioma['sigla'].'" id="texto_curto'.$idioma['sigla'].'" cols="90" rows="3">'.$idioma['descricao'].'</textarea>
                                    </td></tr>';  
                        }
                    }else{
                        foreach($idiomas as $idioma){
                            echo '<tr><td class="titulo_noticias" style="font-weight: normal;">'.$idioma['nome'].'</td>
                                  <td class="titulo_noticias">                                     
                                         <textarea name="texto_curto'.$idioma['sigla'].'" id="texto_curto'.$idioma['sigla'].'" cols="90" rows="3"></textarea>
                                    </td></tr>';
                        }
                    }
                            
              ?>
          </table> 
        </td>
  </tr>  
    <?php } ?>

  <tr>
    <td colspan="2" align="right" class="titulo_noticias">
      <input type="submit" value="Atualizar" class="botao_form">	</td>
  </tr>
</table>
</form>
	<script type="text/javascript">
        new Validation('form');
    </script>
    
<?php 
function monta_textarea($idiomas,$nome){
    $text_html='';
    foreach($idiomas as $item){
        $text_html.= '<td class="titulo_noticias" style="font-weight: normal;">'.$item['nome'].'</td>
            <td class="titulo_noticias">
                <textarea name="'.$nome.$item['sigla'].'" id="'.$nome.$item['sigla'].'" cols="38" rows="3"></textarea>
            </td>';
    }
    return $text_html;
}
function monta_input($idiomas,$nome){
    foreach($idiomas as $item){
        echo '<td class="titulo_noticias" style="font-weight: normal;">'.$item['nome'].'</td>
        <td class="titulo_noticias"><label>
            <input name="'.$nome.$item['sigla'].'" type="text" id="'.$nome.$item['sigla'].'" size="55" />
        </label></td>';
    }
}
?>