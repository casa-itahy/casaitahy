<div class="topo-paginas topo-cases">
    <div class="container text-center">
        <h2><?php echo $pagina['titulo']; ?></h2>
        <div class="row justify-content-center">
            <div class="col-lg-5 anime">
                <h1><?php echo $pagina['subtitulo']; ?></h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="espaco-menor"></div>
    <?php if (!empty($cases)): ?>
        <div class="alinha-titulo-sombra">
            <div class="titulo-sombra">Cases</div>
        </div>
        <div class="alinha-cases">
            <div class="row">
                <div id="owl-cases" class="owl-carousel">
                    <?php foreach ($cases as $bn): ?>
                        <div class="case-individual">
                            <div class="caixa-imagem">
                                <img data-src="<?php echo IMAGENS.'banners/grupo'.$bn['grupo'].'/'.$bn['src']; ?>" alt="<?php echo $bn['nome']; ?>" title="<?php echo $bn['nome']; ?>" class="owl-lazy" />
                            </div>
                            <div class="selo-case">
                                vendido em <span><?php echo $bn['texto']; ?></span> <?php echo $bn['descricao']; ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <div class="espaco"></div>
    <?php endif; ?>
    <?php if (!empty($depoimentos)): ?>
        <div class="alinha-titulo-sombra centralizado">
            <div class="titulo-sombra">Depoimentos</div>
        </div>
        <?php if ($textos[0]['status'] == 1) { ?>
            <div class="container anime text-center">
                <h2 class="texto-azul titulo-centralizado"><?php echo $textos[0]['titulo']; ?></h2>
                <?php echo $textos[0]['conteudo']; ?>
            </div>
        <?php } ?>
        <div class="espaco-menor"></div>
        <div class="container container-large anime">
            <div class="row">
                <div id="owl-depoimentos" class="owl-carousel">
                    <?php foreach ($depoimentos as $te): ?>
                        <div class="depoimento-individual">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <?php if (!empty($te['imagem'])) { ?>
                                        <div class="imagem-depoimento">
                                            <img data-src="<?php echo IMAGENS."noticias/".$te['imagem'];?>" alt="<?php echo $te['titulo']; ?>" title="<?php echo $te['titulo']; ?>" class="owl-lazy" />
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-6">
                                    <div class="texto-depoimento text-white text-center">
                                        <?php echo $te['conteudo']; ?>
                                        <h3><strong><?php echo $te['titulo']; ?></strong>, <?php echo $te['descricao']; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    <?php endif ?>
</div>
<div class="espaco"></div>