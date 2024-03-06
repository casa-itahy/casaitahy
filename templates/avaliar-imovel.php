<?php if ($pagina) { ?>

    <div class="topo-paginas topo-imoveis">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8 anime">
                    <h2>
                        <?php echo $pagina['titulo']; ?>
                    </h2>

                </div>
            </div>
        </div>
    </div>
    <!-- <div class="alinha-titulo-sombra sombra-topo-pagina">
        <div class="titulo-sombra">Avalie Grátis</div>
    </div> -->
    <div class="container">
        <div class="row mt-3 mb-4">
            <div class="col-lg-8 col-md-8 anime">
                <h2 class="texto-laranja mb-0">
                    <?php echo $textos[0]['titulo']; ?>
                </h2>
                <h3 class="texto-azul">
                    <?php echo $textos[0]['title']; ?>
                </h3>
            </div>
        </div>
        <div class="row align-items-end mt-4 ">
            <div class="col-lg-6 col-md-6 anime">
                <?php echo $textos[0]['conteudo']; ?>
            </div>

            <div class="col-lg-6 col-md-6 anime">
                <?php if (!empty($textos[0]['imagem'])) { ?>
                    <div class="imagem-pagina-calculadora">
                        <img src="<?php echo IMAGENS . 'paginas/' . $textos[0]['imagem']; ?>"
                            alt="<?php echo $textos[0]['titulo']; ?>" title="<?php echo $textos[1]['titulo']; ?>" />
                    </div>
                <?php } ?>
            </div>
        </div>

        <br><br>
        <div class="row mt-5 anime">
            <div class="col-sm-12 text-center">
                <h2 class="texto-roxo mb-2">
                    <?php echo $textos[1]['title']; ?>
                </h2>
            </div>
        </div>
        <div class="row texto-quem-somos-baixo anime ">
            <div class="col-sm-4">
                <?php if (!empty($textos[1]['imagem'])) { ?>
                    <div class="imagem-pagina-calculadora-baixo empresa-baixo-desktop">
                        <img src="<?php echo IMAGENS . 'paginas/' . $textos[1]['imagem']; ?>"
                            alt="<?php echo $textos[1]['titulo']; ?>" title="<?php echo $textos[1]['titulo']; ?>" />
                    </div>
                <?php } ?>
            </div>
            <div class="col-sm-8 metodo-personalizado">
                <?php echo $textos[1]['conteudo']; ?>
            </div>
            <?php if (!empty($textos[1]['imagem'])) { ?>
                <div class="imagem-pagina-calculadora-baixo empresa-baixo-mobile">
                    <img src="<?php echo IMAGENS . 'paginas/' . $textos[1]['imagem']; ?>"
                        alt="<?php echo $textos[1]['titulo']; ?>" title="<?php echo $textos[1]['titulo']; ?>" />
                </div>
            <?php } ?>
        </div>

        <div class="texto-quem-somos-baixo anime row">
            <div class="col-sm-4">
                <div class="d-flex flex-column text-center">
                    <img src="admin/imagens/editor/Calculator.png" class="mx-auto mb-3" alt="calculadora" width="60" height="60">
                    <p>
                        Calculadora baseada em dados reais de anúncios
                        imobiliários 100% atualizados.
                    </p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="d-flex flex-column text-center">
                    <img src="admin/imagens/editor/Badge.png" class="mx-auto mb-3" alt="badge" width="60" height="60">
                    <p>
                        Avaliação de especialista que considera fatores
                        como localização, condição, demanda e outras características únicas.
                    </p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="d-flex flex-column text-center">
                    <img src="admin/imagens/editor/Hand-shake.png" class="mx-auto mb-3" alt="hand-shake" width="60" height="60">
                    <p>
                        Compromisso em oferecer uma avaliação precisa que
                        assegura o valor potencial do seu patrimônio.
                    </p>
                </div>
            </div>
        </div>


        <div class="espaco-menor"></div>
        <div class="texto-quem-somos-baixo anime">
            <div class="calculadora" style="display: flex; justify-content: center;">
                <iframe src="https://pricing-app.nivu.com.br/6518cc54-9972-4576-ac38-6fe6af97e36c" width="900px"
                    height="650px" frameborder="0">Seu navegador não suporta iframes.
                </iframe>
            </div>
        </div>

        <div class="texto-quem-somos-baixo anime mb-5">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <?php echo $textos[3]['conteudo']; ?>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-sm-12 text-center">
                    <a href="<?php echo $linkWhatsapp; ?>" class="btn btn-outline-dark">Fale com Especialista</a>
                </div>
            </div>
            
        </div>

        <div class="clearfix"></div>
    </div>
    <div class="espaco"></div>
<?php } ?>