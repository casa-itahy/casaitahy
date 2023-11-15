<div class="topo-paginas topo-imoveis">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8 anime">
                <h2><?php echo $pagina['titulo']; ?></h2>
                <h1><?php echo $pagina['subtitulo']; ?></h1>
            </div>
        </div>
    </div>
</div>
<div class="espaco"></div>
<div class="container">
    <div class="alinha-titulo-sombra centralizado">
        <div class="titulo-sombra">Imóveis</div>
    </div>
    <?php if ($textos['status'] == 1) { ?>
        <div class="container anime text-center">
            <h2 class="texto-laranja titulo-centralizado"><?php echo $textos['titulo']; ?></h2>
            <?php echo $textos['conteudo']; ?>
        </div>
    <?php } ?>
    <div class="espaco-menor"></div>
</div>
<?php if (!empty($produtos)): ?>
    <div class="alinha-cases pt-0">
        <div class="row">
            <?php foreach ($produtos as $produto): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="case-individual imovel-individual">
                        <a href="<?php echo $produto['lin_nome']; ?>" class="caixa-imagem">
                            <?php if (!empty($produto['imagem'])): ?>
                                <img data-src="<?php echo IMAGENS.'produtos/'.$produto['imagem']; ?>" alt="<?php echo $produto['titulo']; ?>" title="<?php echo $produto['titulo']; ?>" />
                            <?php else: ?>
                                <img src="templates/img/sem-imagem-noticias.jpg" alt="<?php echo $produto['titulo']; ?>" title="<?php echo $produto['titulo']; ?>" />
                            <?php endif ?>
                        </a>
                        <a href="<?php echo $produto['lin_nome']; ?>" class="hover-imovel">
                            <h3><?php echo $produto['titulo']; ?></h3>
                            <p><?php echo (!empty($produto['metragem'])) ? $produto['metragem'].' m² | ' : ''; ?><?php echo (!empty($produto['dormitorios'])) ? $produto['dormitorios'].' dormitório(s) | ' : ''; ?><?php echo (!empty($produto['vagas'])) ? $produto['vagas'].' vaga(s) ' : ''; ?></p>
                            <span>mais detalhes</span>
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
<?php else: ?>
    <div class="container">
        <div class="alert alert-danger text-center">Nenhum imóvel cadastrado no momento!</div>
    </div>
<?php endif ?>
<div class="espaco"></div>