<?php 

include("php/sessao.php");
session_write_close();

$sql = "SELECT id,email,nome FROM clientes WHERE newsletter = 1 ORDER BY created ";
$retorno = query($sql);

$css = '';

?>

<script language ="JavaScript">
function confirmar(query){
	if(window.confirm("Deseja realmente excluir esse contato?"))
	{
            window.location= query;
            return true;
	}
}

function exportar()
{
	var url = 'php/geraCSV.php';
	var myAjax = new Ajax.Updater( 
	'link',
	url,{method:'post'});

}

</script>


<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="15" align="center"><p class="msg"><?php echo $_GET['msg']; ?></p></td>
  </tr>
  <tr>
    <td align="left" class="titulo_noticias"><h1>Contatos para envio de Newsletter</h1></td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">
    <table width="100%" border="0" cellspacing="2" cellpadding="3">
      <tr>

            <td width="200" align="center" bgcolor="#004882" class="texto_rodape">Nome</td>
            <td width="200" align="center" bgcolor="#004882" class="texto_rodape">E-mail</td>
          <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Excluir</td>
        </tr>
      <?php foreach ($retorno as $x){
			  if ($css == "#EFEFEF") {
				$css = "#FFFFFF";
			  }  else  {
				$css = "#EFEFEF";
			  }
	  ?>
      <tr>

        <td bgcolor="<?php echo $css; ?>" class="texto_contato"><?php echo $x['nome']?></td>
        <td bgcolor="<?php echo $css; ?>" class="texto_contato"><?php echo $x['email']?></td>
        
        <td align="center" bgcolor="<?php echo $css; ?>" class="texto_contato">
        <a href="javascript:confirmar('php/excluir.php?id=<?php echo $x['id']?>&t=6')"><img src="img/excluir.gif" alt="Excluir" width="17" height="18" border="0"> </a>        </td>
        </tr>
      <?php }?>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="titulo_noticias">
		<div id="link"><a href="#" onclick="exportar()" >Exportar em arquivo CSV</a></div>
    </td>
  </tr>
</table>

