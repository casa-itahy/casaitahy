<?php 
include("php/sessao.php");
session_write_close();
include("includes/conexao.php");


?>

<script language ="JavaScript">
function confirmar(query){
	if(window.confirm("Deseja realmente excluir esse conte�do?"))
	{
		window.location= query;
	   return true;
	}

}
</script>
<?php 
function tipo($tipo)
{
	switch($tipo)
	{
		case 1:
		return "Conte�do Simples";
		break;
		
		case 2:
		return "Lista de Not�cias";
		break;
		
		case 3:
		return "Lista de �lbuns";
		break;
		
		case 4:
		return "Formul�rio de Contato";
		break;
		
		case 5:
		return "Banner Lateral";
		break;
		
		case 6:
		return "Capa do Site";
		break;
		
		case 11:
		return "Cat�logo de Produtos";
		break;
		
		case 12:
		return "Lista de Revendedores";
		break;
	}
}

?>

<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr> 
  <tr>
    <td height="15" align="center"><p class="msg"><?php echo $_GET[msg]; ?></p></td>
  </tr>
  <tr>
    <td align="left" class="titulo_noticias"><table width="150" border="0" cellspacing="0" cellpadding="00">
      <tr>
        <td width="45" align="center"><a href="index.php?pag=10"><img src="img/incluir.png" alt="" width="45" height="50" border="0" /></a></td>
        <td class="titulo_noticias">P&aacute;ginas</td>
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
            <td width="250" height="28"   bgcolor="#004882" class="texto_rodape">T&iacute;tulo</td>
            <td width="100" align="center" bgcolor="#004882" class="texto_rodape">Tipo</td>
            <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Editar</td>
            <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Visivel</td>
            <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Excluir</td>
            <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Sobe</td>
            <td width="40" align="center" bgcolor="#004882" class="texto_rodape">Desce</td>
        </tr>
<?php
function lista($idpai)
{
	$sql=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id, idpai, titulo, status, tipo FROM paginas WHERE idpai='$idpai' ORDER BY posicao ASC");
    if(mysqli_num_rows($sql)!=0)
	{
    	while($res=mysqli_fetch_array($sql))
		{
        	$sql2=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id, idpai, titulo, status, tipo FROM paginas WHERE idpai='$res[id]' ORDER BY posicao ASC");
            $widpai=$res["id"];
			$esp="";
            while($widpai!=0)
			{
            $sql3=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT idpai FROM paginas WHERE id='$widpai'");
            $res3=mysqli_fetch_array($sql3);
            $widpai=$res3["idpai"];
				if($widpai!=0) 
				{
					$esp = $esp."&nbsp;&nbsp;&nbsp;&nbsp;";
				}
			}
			
			
        print"
			<tr> 
    	    	<td bgcolor=\"$css\" class=\"texto_contato_cat\">$esp $res[titulo]</td>";
				$tipo = tipo($res[tipo]);
        print"				
				<td bgcolor=\"$css\" class=\"texto_contato_cat\">$tipo</td>
				<td align=\"center\" class=\"texto_contato_cat\">
				<a href=\"index.php?pag=11&id=$res[id]\">
					<img src=\"img/editar.gif\" alt=\"Editar\" width=\"18\" height=\"20\" border=\"0\"></a>
				</td>
				";
				
				if ($res['status']==1)
				{ 
					print"
					<td align=\"center\" class=\"texto_contato_cat\">
						<a href=\"php/desativar.php?id=$res[id]&v=0&t=1\">
						<img src=\"img/desativar.gif\" alt=\"Ativar\" width=\"14\" height=\"18\" border=\"0\"></a>
					</td>
					";
				}
				else
				{
					print"
					<td align=\"center\" class=\"texto_contato_cat\">
						<a href=\"php/desativar.php?id=$res[id]&v=1&t=1\">
						<img src=\"img/ativar.gif\" alt=\"Ativar\" width=\"14\" height=\"18\" border=\"0\"></a>
					</td>
					";
				}
		print"	
			<td align=\"center\" class=\"texto_contato_cat\">
				<a href=\"javascript:confirmar('php/excluir.php?id=$res[id]&t=1')\">
				<img src=\"img/excluir.gif\" alt=\"Excluir\" width=\"17\" height=\"18\" border=\"0\"> </a>
			</td>	
			 <td align=\"center\" class=\"texto_contato_cat\">
			 	<a href=\"php/sobeP.php?id=$res[id]&t=1&p=$res[idpai]\">
				<img src=\"img/sobe.gif\" alt=\"Sobe\" width=\"14\" height=\"20\" border=\"0\"></a>
			</td>
			<td align=\"center\" class=\"texto_contato_cat\">
				<a href=\"php/desceP.php?id=$res[id]&t=1&p=$res[idpai]\">
				<img src=\"img/desce.gif\" alt=\"Desce\" width=\"14\" height=\"20\" border=\"0\"></a>
			</td>
			
			</tr>
       ";
			if(mysqli_fetch_array($sql2))
			{
				lista($res["id"]);
			}
    	}
   }
}
   lista(0);        
?>        
     
    </table>
    </td>
  </tr>
  <tr>
    <td align="center" class="titulo_noticias">&nbsp;</td>
  </tr>
</table>

