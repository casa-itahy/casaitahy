<div class="topo-paginas topo-parceiros">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8 anime">
                <h2><?php echo $pagina['titulo']; ?></h2>
                <h1><?php echo $pagina['subtitulo']; ?></h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="espaco-menor"></div>
    <?php if (!empty($parceiros)): ?>
        <div id="owl-parceiros" class="owl-carousel"> <!-- owl-interno -->
            <?php foreach ($parceiros as $bn) { ?>
                <div class="parceiro-individual">
                    <img class="owl-lazy" data-src="<?php echo IMAGENS.'banners/grupo'.$bn['grupo'].'/'.$bn['src']; ?>" alt="<?php echo $bn['nome']; ?>" title="<?php echo $bn['nome']; ?>" />
                </div>
            <?php } ?>
        </div>
        <div class="text-center">
            <a href="<?php echo $linkContato; ?>" class="btn btn-primary">Quero ser um parceiro</a>
        </div>
    </div>
    <?php endif ?>
</div>
<?php if (!empty($depoimentos)): ?>
    <div id="depoimentos"></div>
    <div class="espaco"></div>
    <div class="alinha-titulo-sombra centralizado">
        <div class="titulo-sombra">Parceiros</div>
    </div>
    <?php if ($textos[0]['status'] == 1) { ?>
        <div class="container anime text-center">
            <h2 class="texto-azul titulo-centralizado"><?php echo $textos[0]['titulo']; ?></h2>
            <?php echo $textos[0]['conteudo']; ?>
        </div>
    <?php } ?>
    <div class="container anime">
        <div class="espaco-menor"></div>
        <div class="row">
            <?php foreach ($depoimentos as $te): ?>
                <div class="col-md-6 depoimento-individual-parceiros">
                    <div class="texto-depoimento text-white text-center h-100">
                        <?php echo $te['conteudo']; ?>
                        <h3><strong><?php echo $te['titulo']; ?></strong>, <?php echo $te['descricao']; ?></h3>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="text-center pt-20">
            <?php if($total_paginas > 1) { ?>
                <div class="paginacao-blog">
                    <?php if ($total_paginas > 5): ?>
                        <?php if ($paginacao > 1) { ?>
                            <a href="<?php echo $pag; ?>/&pager=<?php echo $paginacao-1; ?>#depoimentos"><i class="fas fa-angle-double-left"></i></a>
                        <?php } ?>
                        <?php if ($paginacao <= 5): ?>
                            <?php for($i=1; $i <= 6; $i++){ ?>
                                <a href="<?php echo $pag; ?>/&pager=<?php echo $i; ?>#depoimentos" <?php if($i == $paginacao) { ?>class="pager-ativo"<?php } ?>><?php echo $i; ?></a>
                            <?php } ?>
                        <?php else: ?>
                            <?php 
                                $pagInicio = $paginacao - 3;
                                $pagFinal = $paginacao + 3;
                                if ($pagFinal >= $total_paginas) {
                                    $pagFinal = $total_paginas;
                                }
                                
                            ?>
                            <?php for($i=$pagInicio; $i <= $pagFinal; $i++){ ?>
                                <a href="<?php echo $pag; ?>/&pager=<?php echo $i; ?>#depoimentos" <?php if($i == $paginacao) { ?>class="pager-ativo"<?php } ?>><?php echo $i; ?></a>
                            <?php } ?>
                        <?php endif ?>
                    <?php else: ?>
                        <?php for($i=1; $i <= $total_paginas; $i++){ ?>
                            <a href="<?php echo $pag; ?>/&pager=<?php echo $i; ?>#depoimentos" <?php if($i == $paginacao) { ?>class="pager-ativo"<?php } ?>><?php echo $i; ?></a>
                        <?php } ?>
                    <?php endif ?>
                    <?php $botaoProximo = $paginacao+1;
                        if ($botaoProximo <= $total_paginas) { ?>
                            <a href="<?php echo $pag; ?>/&pager=<?php echo $botaoProximo; ?>#depoimentos"><i class="fas fa-angle-double-right"></i></a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php endif ?>
<div class="espaco"></div>