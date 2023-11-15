<?php 
include_once("php/sessao.php");
session_write_close();
include_once("includes/db.php");
	
$sql = "SELECT d.*, c.titulo FROM downloads d LEFT JOIN docs c ON(c.id = d.arquivo) ORDER BY d.created DESC";
$retorno = query($sql);

?>

<script language ="JavaScript">
function confirmar(query){
	if(window.confirm("Deseja realmente excluir esse distribuidor?")){
            window.location= query;
	    return true;
	}
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
    <td align="left" class="titulo_noticias"><table width="150" border="0" cellspacing="0" cellpadding="00">
      <tr>
        <td class="titulo_noticias">
          <?php echo $paginas['titulo']; ?>
        </td>
      </tr>
    </table>      
    </td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">
    <table width="100%" border="0" cellspacing="2" cellpadding="3">
      <tr>
            <td width="150" bgcolor="#004882" class="texto_rodape" height="28">Nome</td>
            <td width="150" bgcolor="#004882" class="texto_rodape">Email</td>
            <td width="150" bgcolor="#004882" class="texto_rodape">Arquivo</td>
            <td width="100" bgcolor="#004882" class="texto_rodape">Data</td>
     </tr>
	<?php 
          foreach ($retorno as $x){
		  if ($css == "#EFEFEF"){ $css = "#FFFFFF"; }else{ $css = "#EFEFEF"; } ?>
          <tr>
            <td bgcolor="<?php echo $css; ?>" class="texto_contato"><?php echo $x['nome']?></td>
            <td bgcolor="<?php echo $css; ?>" class="texto_contato"><?php echo $x['email']?></td>
            <td bgcolor="<?php echo $css; ?>" class="texto_contato"><?php echo $x['titulo']?></td>
            <td bgcolor="<?php echo $css; ?>" class="texto_contato"><?php echo date('d/m/Y H:m', strtotime($x['created']));?></td>
          </tr>
      <?php }?>
    </table>
    </td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
</table>

