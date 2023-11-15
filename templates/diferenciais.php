<div class="topo-paginas topo-diferenciais">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8 anime">
                <h2><?php echo $conteudo_pagina['titulo']; ?></h2>
                <h1><?php echo $conteudo_pagina['subtitulo']; ?></h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="espaco-menor"></div>
    <?php foreach ($diferenciais as $key => $te): ?>
        <div class="row align-items-center diferencial-individual-interna <?php if ($te['autor'] == '1'): ?>diferencial-laranja<?php elseif($te['autor'] == '2'): ?>diferencial-azul<?php else: ?>diferencial-roxo<?php endif ?>" id="<?php echo $te['id']; ?>">
            <div class="col-lg-7 col-md-6 <?php echo ($key % 2 == 0) ? 'order-md-1' : 'order-md-2'; ?>">
                <?php if (!empty($te['imagem'])) { ?>
                    <div class="image-diferencial"><img class="owl-lazy" data-src="<?php echo IMAGENS."noticias/".$te['imagem']; ?>" alt="<?php echo $te['titulo']; ?>" title="<?php echo $te['titulo']; ?>"></div>
                <?php } ?>
            </div>
            <div class="col-lg-5 col-md-6 diferencial-texto <?php echo ($key % 2 == 0) ? 'order-md-2' : 'order-md-1'; ?>">
                <h3><?php echo $te['titulo']; ?></h3>
                <?php echo $te['conteudo']; ?>
            </div>
        </div>
    <?php endforeach ?>
</div>
<?php if ($textos[0]['status'] == 1) { ?>
    <div class="frase-home">
        <div class="container anime text-center">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <?php echo $textos[0]['conteudo']; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="espaco"></div>
<?php } ?>