<?php if ($textos[0]['status'] == 1) { ?>
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="capa-video-esquerda anime">
                    <h1><?php echo $textos[0]['titulo']; ?></h1>
                    <?php echo $textos[0]['conteudo']; ?>
                    <a class="btn btn-primary" href="<?php echo $linkSobre; ?>">Saiba mais</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="capa-video">
                    <iframe src="https://www.youtube.com/embed/<?php echo idVideo($textos[0]['metad']); ?>?controls=0&showinfo=0&rel=0&autoplay=1&loop=1&playlist=<?php echo idVideo($textos[0]['metad']); ?>&mute=1" frameborder="0" allowfullscreen></iframe>
                
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($textos[1]['status'] == 1) { ?>
    <div class="espaco"></div>
    <div class="container anime">
        <div class="alinha-titulo-sombra">
            <div class="titulo-sombra">Quem Somos</div>
        </div>
        <div class="row align-items-end">
            <div class="col-lg-7 col-md-6">
                <?php if(!empty($textos[1]['imagem'])) { ?>
                    <div class="imagem-capa-quem-somos">
                        <img src="<?php echo IMAGENS.'paginas/'.$textos[1]['imagem']; ?>" alt="<?php echo $textos[1]['titulo']; ?>" title="<?php echo $textos[1]['titulo']; ?>" />
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-5 col-md-6 capa-quem-somos">
                <h2 class="texto-azul"><?php echo $textos[1]['titulo']; ?></h2>
                <?php echo $textos[1]['conteudo']; ?>
                <a class="btn btn-secondary" href="<?php echo $linkSobre; ?>">Saiba mais</a>
            </div>
        </div>
    </div>
    <div class="espaco-quem-somos"></div>
<?php } ?>
<div class="bg-diferenciais">
    <div class="espaco"></div>
    <?php if ($textos[2]['status'] == 1) { ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 text-center text-white">
                    <h2 class="texto-laranja"><?php echo $textos[2]['titulo']; ?></h2>
                    <?php echo $textos[2]['conteudo']; ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="container">
        <div id="owl-diferenciais" class="owl-carousel">
            <?php foreach ($diferenciais as $key => $te): ?>
                <div class="diferencial-individual <?php if ($te['autor'] == '1'): ?>diferencial-laranja<?php elseif($te['autor'] == '2'): ?>diferencial-azul<?php else: ?>diferencial-roxo<?php endif ?>">
                    <?php if (!empty($te['icone'])) { ?>
                        <span class="icone-diferencial"><img class="owl-lazy" data-src="<?php echo IMAGENS."noticias/icones/".$te['icone']; ?>" alt=""></span>
                    <?php } ?>
                    <h3><?php echo $te['titulo']; ?></h3>
                    <p><?php echo limita_caracteres(strip_tags($te['conteudo']), 94, false); ?></p>
                    <a href="<?php echo $linkDiferenciais."#".$te['id']; ?>" class="btn-diferencial"><i class="fas fa-arrow-right"></i></a>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="espaco"></div>
</div>
<?php if (!empty($parceiros)): ?>
    <div class="espaco"></div>
    <div class="container">
        <?php if ($textos[3]['status'] == 1) { ?>
            <div class="row justify-content-center">
                <div class="col-lg-9 text-center">
                    <h2 class="texto-roxo"><?php echo $textos[3]['titulo']; ?></h2>
                    <?php echo $textos[3]['conteudo']; ?>
                </div>
            </div>
        <?php } ?>
        <div id="owl-parceiros" class="owl-carousel">
            <?php foreach ($parceiros as $bn) { ?>
                <div class="parceiro-individual">
                    <img class="owl-lazy" data-src="<?php echo IMAGENS.'banners/grupo'.$bn['grupo'].'/'.$bn['src']; ?>" alt="<?php echo $bn['nome']; ?>" title="<?php echo $bn['nome']; ?>" />
                </div>
            <?php } ?>
        </div>
        <div class="text-center">
            <a href="parceiros-imoveis-no-itaim-bibi" class="btn btn-primary">Ver todos</a>
        </div>
    </div>
<?php endif ?>
<?php if (!empty($depoimentos)): ?>
    <div class="espaco"></div>
    <div class="alinha-titulo-sombra centralizado">
        <div class="titulo-sombra">Depoimentos</div>
    </div>
    <?php if ($textos[4]['status'] == 1) { ?>
        <div class="container anime text-center">
            <h2 class="texto-azul titulo-centralizado"><?php echo $textos[4]['titulo']; ?></h2>
            <?php echo $textos[4]['conteudo']; ?>
        </div>
    <?php } ?>
    <div class="container pt-50 anime">
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
        <div class="text-center">
            <a href="cases-depoimentos-imoveis-itaim-bibi" class="btn btn-secondary">Ver todos</a>
        </div>
    </div>
<?php endif ?>
<?php if (!empty($cases)): ?>
    <div class="espaco"></div>
    <div class="alinha-titulo-sombra">
        <div class="titulo-sombra">Cases</div>
    </div>
    <div class="alinha-cases">
        <div class="row">
            <?php foreach ($cases as $bn): ?>
                <div class="col-md-4">
                    <div class="case-individual">
                        <a href="<?php echo $linkCases; ?>" class="caixa-imagem">
                            <img data-src="<?php echo IMAGENS.'banners/grupo'.$bn['grupo'].'/'.$bn['src']; ?>" alt="<?php echo $bn['nome']; ?>" title="<?php echo $bn['nome']; ?>" />
                        </a>
                        <a href="<?php echo $linkCases; ?>" class="selo-case">
                            vendido em <span><?php echo $bn['texto']; ?></span> <?php echo $bn['descricao']; ?>
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="text-center pt-20">
            <a href="<?php echo $linkCases; ?>" class="btn btn-dark">Ver todos</a>
        </div>
    </div>
    <div class="espaco"></div>
<?php endif; ?>
<?php if ($textos[5]['status'] == 1) { ?>
    <div class="frase-home">
        <div class="container anime text-center">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <?php echo $textos[5]['conteudo']; ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (!empty($noticias)): ?>
    <div class="bg-blog">
        <div class="espaco"></div>
        <div class="alinha-titulo-sombra centralizado">
            <div class="titulo-sombra">Blog</div>
        </div>
        <?php if ($textos[6]['status'] == 1) { ?>
            <div class="container anime text-center">
                <h2 class="texto-laranja titulo-centralizado"><?php echo $textos[6]['titulo']; ?></h2>
                <?php echo $textos[6]['conteudo']; ?>
            </div>
        <?php } ?>
        <div class="container pt-50">
            <div class="row">
                <?php foreach ($noticias as $key => $nt) { ?>
                    <div class="col-md-4 noticia-individual">
                        <a href="<?php echo $nt['lin_nome']; ?>" class="caixa-imagem-noticia">
                            <?php if (!empty($nt['imagem'])) { ?>
                                <img src="<?php echo IMAGENS."noticias/thumb_".$nt['imagem'];?>" alt="<?php echo $nt['titulo']; ?>" title="<?php echo $nt['titulo']; ?>" />
                            <?php } else { ?>
                                <img src="templates/img/sem-imagem-noticias.jpg" alt="<?php echo $nt['titulo']; ?>" title="<?php echo $nt['titulo']; ?>" />
                            <?php } ?>
                        </a>
                        <a href="<?php echo $nt['lin_nome']; ?>"><h3><?php echo $nt['titulo']; ?></h3></a>
                        <a href="<?php echo $nt['lin_nome']; ?>" class="btn-underline">leia mais</a>
                    </div>
                <?php } ?>
            </div>
            <div class="text-center">
                <a href="<?php echo $linkNoticias; ?>" class="btn btn-orange">Ver todos</a>
                <div class="espaco"></div>
            </div>
        </div>
    </div>
<?php endif ?>