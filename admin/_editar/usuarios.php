<?php 
include_once("php/sessao.php");
$id_usu=$_SESSION['id'];    
$nivel=$_SESSION['nivel'];
session_write_close();
    
$id = $_GET['id'];

$sql = "SELECT * FROM usuarios	WHERE id=$id ";
$usuario = query($sql);
//var_dump($_SESSION);die();
$sql = "SELECT m.id,m.descricao
	FROM modulos m
    INNER JOIN usuarios_modulos um ON (m.id = um.modulo_id)
	WHERE um.usuario_id= '$id' AND m.status=1 ";//AND m.pag_tab_nome!='usuarios' AND m.pag_tab_nome!='config'";

$marcadas = query($sql);

 if($id_usu!='null' && $id_usu!=''){
        session_write_close();
        if($id_usu==1){
            $sql = "SELECT m.id, m.descricao,m.pag_tab_nome FROM modulos m WHERE m.status=1 AND m.descricao IS NOT NULL order by titulo";
        }else{
            $sql = "SELECT m.id, m.descricao,m.pag_tab_nome FROM modulos m
                        INNER JOIN usuarios_modulos um ON(m.id = modulo_id) WHERE um.usuario_id=".$id_usu." AND m.status=1 AND m.descricao IS NOT NULL order by m.titulo"; //AND pag_tab_nome!='usuarios' AND pag_tab_nome!='config'";
        }
        $modulos = query($sql);       
}else{  
    session_write_close();
    header('Location: ../php/sair');
    exit;
}
	
/*foreach($marcadas as $u){
	$ni.=$u['page'].",";
}
if($ni){
	$ni = substr($ni, 0, -1);
}else{
	$ni=-0;
}

$sql = "SELECT id, titulo FROM art_menu_adm WHERE id NOT IN($ni) AND status!=0";
$desmarcadas = query($sql);

$unidos = array_merge($marcadas, $desmarcadas);

foreach ($unidos as $key => $row) {
    $ids[$key]  = $row['id'];
}

array_multisort($ids, SORT_ASC, $unidos);*/

?>

	<script type="text/javascript" src="js/validation.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css" />

<script language="javascript">
function lowcase(form){
    var texto = document.getElementById('usuario').value;
	texto = texto.replace(' ','');
	document.getElementById('usuario').value = texto;
        }
</script>

<form action="_update/usuarios.php" enctype="multipart/form-data" method="post" id="form" name="form" >
<input type="hidden" id="tabela" name="tabela" value="usuarios" >
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
    <td width="154" class="titulo_noticias">Nome completo</td>
    <td colspan="2" class="titulo_noticias"><label>
      <input name="nome" type="text" id="nome" size="55"  class="required" value="<?php echo $usuario[0]['nome']; ?>">
    </label></td>
  </tr>

  <tr>
    <td class="titulo_noticias">Login</td>
    <td class="titulo_noticias"><input name="login" type="text" id="login" size="20"  class="required" value="<?php echo $usuario[0]['login']; ?>" onchange="lowcase(this)" /></td>
    <td class="valor_prod">- O sistema ir&aacute; remover espa&ccedil;os em brancos automaticamente.</td>
  </tr>
  <tr>
    <td rowspan="2" class="titulo_noticias">N&iacute;vel de Acesso</td>
    <td width="163" rowspan="2" class="titulo_noticias"><label>
          <select name="nivel" id="nivel"  class="validate-selection">
            <option>-- Escolha --</option>
            <?php if($usuario[0]['nivel'] == 1){ ?>
              <option value="1" selected="selected">Administrador</option>
            <?php } else { ?>
              <option value="1">Administrador</option>
            <?php } ?>
            <?php if($usuario[0]['nivel'] == 0){ ?>
              <option value="0" selected="selected">Gerente</option>
            <?php } else { ?>
              <option value="0">Gerente</option>
            <?php } ?>
          </select>
      </label>
    </td>
    <td width="443" class="valor_prod">- Administrador - Acesso total as paginas permitidas.</td>
  </tr>
  <tr>
    <td class="valor_prod" colspan="2">- Gerente - Proibido acesso aos usuarios, adicionar e remover conte&uacute;dos.</td>
  </tr>
  <tr>
    <td colspan="3" class="titulo_noticias">&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo_noticias">&nbsp;</td>
    <td colspan="2" class="valor_prod">O usu&aacute;rio acima ter&aacute; acesso as p&aacute;ginas marcadas abaixo:</td>
  </tr>
  
  <?php
        $modulos_marcado=array();
        foreach ($marcadas as $p){
            $modulos_marcado[]=$p['descricao'];
        }
        foreach ($modulos as $p){
    ?>
             <tr>
            <td class="titulo_noticias">&nbsp;</td>
            <td colspan="2" class="titulo_noticias">
            <input name="<?php echo $p['id']; ?>" type="checkbox" id="<?php echo $p['id']; ?>" value="1"
            <?php
                if (in_array($p['descricao'],$modulos_marcado)){
                        echo 'checked="checked"';
                }
             ?>
             />
            <?php echo $p['descricao']; ?>
            </td>
            </tr>
<?php
	}
  ?>
  
    <tr>
    <td colspan="3" align="right" class="titulo_noticias">
      <input type="submit" value="Salvar" class="botao_form">	</td>
  </tr>
</table>
</form>
<script type="text/javascript">
	new Validation('form');
</script>
<script type="text/javascript">
		function formCallback(result, form) {
			window.status = "valiation callback for form '" + form.id + "': result = " + result;
		}
		
		var valid = new Validation('form', {immediate : true, onFormValidate : formCallback});
		Validation.addAllThese([
			['validate-password', 'Sua senha deve ser maior que 6 caracteres e n�o pode ser igual ao seu usuario', {
				minLength : 6,
				notOneOf : ['password','PASSWORD','1234567','0123456'],
				notEqualToField : 'usuario'
			}],
			['validate-password-confirm', 'Sua confirma��o de senha n�o � igual a sua primeira senha, por favor repita.', {
				equalToField : 'senha'
			}]
		]);
</script>
	