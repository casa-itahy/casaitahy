<?php 
	include("php/sessao.php");
        session_write_close();

	$id = $_GET['id'];

$sql = "(SELECT i.nome, i.sigla,ki.titulo FROM idiomas i 
            LEFT JOIN docs_idioma ki ON(i.id=ki.idioma_id)
        WHERE i.status=1 AND ki.docs_id=$id ORDER BY i.id)
        UNION ALL
        (SELECT i.nome, i.sigla,null
            FROM idiomas i
            WHERE i.id!=1 AND i.status=1
               AND id NOT IN (SELECT idioma_id FROM docs_idioma WHERE docs_id=$id)
            ORDER BY i.id)";

//var_dump($sql);die();
$dados_idioma = query($sql);

$sql = "SELECT * FROM docs WHERE id=$id";
$dados = query($sql);

$titulo=$dados[0]['titulo'];  
        
/*$sql = "SELECT * FROM docs WHERE id=$id ";
$dados = query($sql);
$titulo = htmlspecialchars ($dados[0]['titulo']);*/

?>
<script type="text/javascript">
	function geraForm()
	{
		var num = document.getElementById('numImg').value;
		if (num > 0)
		{
		var url = 'php/geraFormProd.php?num='+num;
		var myAjax = new Ajax.Updater( 
		'div',
		url,{method:'post'});
		}	
	}

function confirmar(query){
if(window.confirm("Deseja realmente excluir essa imagem?")){
           window.location= query;
	   return true;
	}
}

function limpaForm(){
        document.getElementById('numImg').options[0].selected=true;
        document.getElementById('div').innerHTML = "<br /><a style='padding-left:5%;' href='#' onclick='geraForm();'><img src='img/ok16.png' alt='Gerar campos' width='16' height='16' border='0' ><span style='color:#006A01;'>Gerar</span></a>";
}
</script>
	<script type="text/javascript" src="js/validation.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css" />

<form action="_update/docs.php" enctype="multipart/form-data" method="post" id="form" >
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
  <tr>
    <td colspan="2" class="titulo_noticias">       
<?php
        echo "<table border=0 align=center>                
                
                <tr>
                    <td width='117' class='titulo_noticias'>T&iacute;tulo</td>
                    <td width='819' class='titulo_noticias'><label>
                      <input name='titulo' type='text' id='titulo' size='55'  class='required' value='".$titulo."'>
                    </label></td>
                </tr>
                <tr style='display:none;'>
                    <td width='117' class='titulo_noticias'>Descrição</td>
                    <td width='819' class='titulo_noticias'><label>
                      <textarea name='descricao' rows='4' cols='40'>".$dados[0]['descricao']."</textarea>
                    </label></td>
                </tr>";
        
                if(count($dados_idioma)>0){
                    foreach($dados_idioma as $idioma){
                        $nome = $idioma['nome'];
                        $sigla=$idioma['sigla'];
                        $titulo = $idioma['titulo'];

                        echo "<tr style='display: none;'>
                                <td width='117' class='titulo_noticias'>T&iacute;tulo ".$nome."</td>
                                <td width='819' class='titulo_noticias'><label>
                                  <input name='titulo".$sigla."' type='text' id='titulo".$sigla."' size='55'  class='required' value='".$idioma['titulo']."'>
                                </label></td>
                              </tr>";                        
                    }
                };
                echo"
                <tr>
                <td class='titulo_noticias'>Arquivo</td>
                <td class='titulo_noticias'>";                
                    $srcPdf = $dados[0]['src'];
                    $caminho = "docs_upload/".$srcPdf;
                    if($srcPdf!=""){
                        echo "<a href='".$caminho."'><img src='img/pdf_48x48.png'  border='0'></a><a href='php/apagarCatalogoPdf.php?id=".$id."&pag=".$paginas['pag_tab_id']."'><img src='./img/excluir.gif' alt='Excluir' width='16' height='16' border='0'></a>";
                    }else{
                        echo "<input name='pdf' type='file' id='pdf' size='43'>";
                    }
         echo "</td>
              </tr>
              <tr style='display: none;'>
                <td class='titulo_noticias'>Imagem</td>
                <td class='titulo_noticias'>";
                    $imagem = $dados[0]['imagem'];
                    $caminho = "imagens/docs/".$imagem;
                    if($imagem!=""){
                        echo "<img src=".$caminho."><a href='php/apagarImagem.php?pasta=docs&id=".$id."&pag=".$paginas['pag_tab_id']."'><img src='./img/excluir.gif' alt='Excluir' width='16' height='16' border='0'></a>";
                    }else{
                        echo "<input name='imagem' type='file' id='imagem' size='43'>";
                    }
           echo "</td>
              </tr>                
           </table>";

?>    </td>
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