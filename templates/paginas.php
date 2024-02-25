<?php if ($pagina) { 

    ?>
    <div class="topo-paginas">
        <div class="container text-center">
            <h2><?php echo $pagina['titulo']; ?></h2>
            <h1><?php echo $pagina['subtitulo']; ?></h1>
        </div>
    </div>
    <div class="espaco-menor"></div>
    <div class="container anime">
        <?php if(!empty($pagina['imagem'])) { ?>
            <img src="<?php echo IMAGENS.'paginas/'.$pagina['imagem']; ?>" alt="<?php echo $pagina['titulo']; ?>" title="<?php echo $pagina['titulo']; ?>" class="imagem-principal-paginas" />
        <?php } ?>
        <?php echo $pagina['conteudo']; ?>
        <div class="clearfix"></div>
    </div>
    <div class="espaco"></div>
<?php } ?>