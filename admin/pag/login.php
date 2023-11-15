<html>
<head>
    <meta HTTP-EQUIV="Pragma" CONTENT="no-cache"/>
    <meta HTTP-EQUIV="Expires" CONTENT="-1"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>ADM - ARTWEBDIGITAL</title>    
    <link href="../css/default.css" rel="stylesheet" type="text/css" />   
</head>

<script>
	var VAjaxObjects = new Array();
	var VErro = 0
	var VCountErro = 0
	var vPTimeout = ""
	
	function CampoOnfocus(pobj){
		pobj.style.border = '1px solid #ffe38d'
		pobj.style.backgroundColor = '#FAFFBD;'		
	}
	
	function CampoOnblur(pobj)
	{
		pobj.style.border = '1px solid #eaeaea'
		pobj.style.backgroundColor = '#fff'		
	}	
	
	function submitenter(myfield,e)
	{
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	
	if (keycode == 13)
		 {
				if (TrimJS(document.form.NomeLoja.value)=="")
				{
					document.form.NomeLoja.focus()
					return true;
				}
				if (TrimJS(document.form.NomeUsuario.value)=="")
				{
					document.form.NomeUsuario.focus()
					return true;
				}			
				if (TrimJS(document.form.SenhaUsuario.value)=="")
				{
					document.form.SenhaUsuario.focus()
					return true;
				}								
			 VerificaLogin();
		 return false;
		 }
	else
		 return true;
	}

	
	function VerificaLogin()
	{
		var vcounterroLp = 0		
		document.getElementById('NomeUsuario').style.border = '1px solid #eaeaea'
		document.getElementById('NomeUsuario').style.backgroundColor = '#fff'	
		document.getElementById('SenhaUsuario').style.border = '1px solid #eaeaea'
		document.getElementById('SenhaUsuario').style.backgroundColor = '#fff'	
	}	
	
</script>

<body>
    <table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td height="503" class="bg-login">    
                <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                    <form method="post" action="../lgn/autentica.php">  
                    <tr>
                        <td width="332" align="center" valign="bottom" class="noticias">&nbsp;</td>
                        <td align="right">
                            <div id=LoginBoxEsquerda>
                            <p class="texto-login">Acesse sua área administrativa</p>  
                            <label>Usuário:</label> 
                            <input type="text" name="usuario" id="usuario" style="background-color: #FAFFBD;"
                            onblur="CampoOnblur(this)" class="CampoTestDrive" onfocus="CampoOnfocus(this);if(window.Teclado.window.NovoFoco!=undefined){window.Teclado.window.NovoFoco(1)}" onkeypress="return submitenter(this,event)" maxLength="20" ><br />
                            <label>Senha:</label> 
                            <input type="password" name="senha" id="senha" onblur="CampoOnblur(this)" class="CampoTestDrive" onfocus="CampoOnfocus(this);if(window.Teclado.window.NovoFoco!=undefined){window.Teclado.window.NovoFoco(2)}" onkeypress="return submitenter(this,event)" maxLength="20" style="background-color: #FAFFBD;"><br />
                            <label></label>
                            </div>
                            <input name="Submit2" type="image" src="../img/btn-entrar.jpg" value="Enviar" />
                            							<script>
                            	window.onload = ScreenSet;	
                            </script>	
                        </td>
                        <td width="50" align="right" class="titulo_noticias">&nbsp;</td>
                    </tr>
                    </form>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
