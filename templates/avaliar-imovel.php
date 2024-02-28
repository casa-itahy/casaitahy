<?php if ($pagina) { ?>
    <div class="alinha-titulo-sombra sombra-topo-pagina">
        <div class="titulo-sombra">Avalie Grátis</div>
    </div>
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-5 col-md-6 anime">
                <h2 class="texto-azul"><?php echo $textos[0]['titulo']; ?></h2>
                <?php echo $textos[0]['conteudo']; ?>
            </div>

            <div class="col-lg-7 col-md-6 anime">
                <?php if(!empty($textos[0]['imagem'])) { ?>
                    <div class="imagem-pagina-empresa">
                        <img src="<?php echo IMAGENS.'paginas/'.$textos[0]['imagem']; ?>" alt="<?php echo $textos[0]['titulo']; ?>" title="<?php echo $textos[1]['titulo']; ?>" />
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="texto-quem-somos-baixo anime">
            <?php if(!empty($textos[1]['imagem'])) { ?>
                <div class="imagem-pagina-empresa-baixo empresa-baixo-desktop">
                    <img src="<?php echo IMAGENS.'paginas/'.$textos[1]['imagem']; ?>" alt="<?php echo $textos[1]['titulo']; ?>" title="<?php echo $textos[1]['titulo']; ?>" />
                </div>
            <?php } ?>
            <?php echo $textos[1]['conteudo']; ?>
            <?php if(!empty($textos[1]['imagem'])) { ?>
                <div class="imagem-pagina-empresa-baixo empresa-baixo-mobile">
                    <img src="<?php echo IMAGENS.'paginas/'.$textos[1]['imagem']; ?>" alt="<?php echo $textos[1]['titulo']; ?>" title="<?php echo $textos[1]['titulo']; ?>" />
                </div>
            <?php } ?>
        </div>


        <div class="espaco-menor"></div>
        <div class="texto-quem-somos-baixo anime">
            <div class="calculadora" style="display: flex; justify-content: center;">
                <iframe src="https://pricing-app.nivu.com.br/6518cc54-9972-4576-ac38-6fe6af97e36c" width="900px" height="650px" frameborder="0">Seu navegador não suporta iframes.
                </iframe>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="espaco"></div>
<?php } ?>