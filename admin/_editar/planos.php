<?php

  include("php/sessao.php");
  session_write_close();
  include_once("includes/functions.php");

    $id = $_GET['id'];

    $sql = "SELECT cs.id,cs.titulo,cs.status,cs.posicao FROM categorias_subcat cs RIGHT JOIN cat_subcat_nivel csn ON (cs.id = csn.cat_pai_id) WHERE csn.cat_filho_id IS NULL AND csn.cat_neto_id IS NULL AND csn.sub_cat_id IS NULL ORDER BY cs.posicao";
    $solucoes = query($sql);

    $dados = query("SELECT * FROM plano_individual WHERE id = ".$id);

?>

<script type="text/javascript" src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<form action="_update/planos.php" method="post" id="form">
    <input type="hidden" id="tabela" name="tabela" value="plano_individual">
    <input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" >
    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
    <table width="950" border="0" align="center" cellpadding="2" cellspacing="2">
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" align="center"><h1>Incluir     
                    <?php
                    echo $paginas['titulo'];
                    session_write_close();
                    ?>
                </h1></td>
        </tr>
        <tr>
            <td width="100" class="titulo_noticias">Solução</td>
            <td>
                <select name="solucao" class="validate-selection">
                    <option value="">Selecione</option>
                    <?php foreach ($solucoes as $key => $so): ?>
                        <option <?php if ($dados[0]['solucao'] == $so['id']): echo "selected='selected'"; endif; ?> value="<?php echo $so['id']; ?>"><?php echo $so['titulo']; ?></option>
                    <?php endforeach ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="100" class="titulo_noticias">Título</td>
            <td><input type="text" size="50" name="titulo" class="required" value="<?php echo $dados[0]['titulo']; ?>" /></td>
        </tr>
        <tr>
            <td width="100" class="titulo_noticias">Valor Plano 1</td>
            <td><input type="text" size="50" name="valor1" value="<?php echo $dados[0]['valor1']; ?>" /></td>
        </tr>
        <tr>
            <td width="100" class="titulo_noticias">Valor Plano 2</td>
            <td><input type="text" size="50" name="valor2" value="<?php echo $dados[0]['valor2']; ?>" /></td>
        </tr>
        <tr>
            <td width="100" class="titulo_noticias">Valor Plano 3</td>
            <td><input type="text" size="50" name="valor3" value="<?php echo $dados[0]['valor3']; ?>" /></td>
        </tr>
        <tr>
            <td width="100" class="titulo_noticias">Valor Plano 4</td>
            <td><input type="text" size="50" name="valor4" value="<?php echo $dados[0]['valor4']; ?>" /></td>
        </tr>
        <tr>
            <td width="100" class="titulo_noticias">Valor Plano 5</td>
            <td><input type="text" size="50" name="valor5" value="<?php echo $dados[0]['valor5']; ?>" /></td>
        </tr>
        <tr>
            <td width="100" class="titulo_noticias">Valor Plano 6</td>
            <td><input type="text" size="50" name="valor6" value="<?php echo $dados[0]['valor6']; ?>" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center" class="titulo_noticias">
                <input type="submit" value="Atualizar" class="botao_form">
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    new Validation('form');
</script>