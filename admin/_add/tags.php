<?php

    include("php/sessao.php");
    session_write_close();
    include_once("includes/functions.php");

?>

<script type="text/javascript" src="js/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<form action="_gravar/tags.php" method="post" id="form">
    <input type="hidden" id="tabela" name="tabela" value="tags">
    <input type="hidden" id="pag" name="pag" value="<?php echo $paginas['pag_tab_id']; ?>" >
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
            <td class="titulo_noticias">Tags<br /><span style="font-weight: normal;">Colocar uma tag por linha.</span></td>
            <td>
                <textarea name="tags" required="required" cols="90" rows="5"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" class="titulo_noticias">
                <input type="submit" value="Incluir" class="botao_form">	</td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    new Validation('form');
</script>