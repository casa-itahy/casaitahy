<?php if ($produto) { ?>
    <div class="topo-paginas topo-imoveis">
        <div class="container text-center">
            <h2><?php echo $produto['titulo']; ?></h2>
            <h1><?php echo (!empty($produto['metragem'])) ? $produto['metragem'].' m² | ' : ''; ?><?php echo (!empty($produto['dormitorios'])) ? $produto['dormitorios'].' dormitório(s) | ' : ''; ?><?php echo (!empty($produto['vagas'])) ? $produto['vagas'].' vaga(s) | ' : ''; ?><?php echo (!empty($produto['cod'])) ? 'Código: '.$produto['cod'] : ''; ?></h1>
        </div>
    </div>
    <div class="container">
        <div class="espaco-menor"></div>
        <div class="text-md-right text-center">
            <a href="<?php echo $linkProdutos; ?>" class="btn btn-primary mb-4">Voltar aos Imóveis</a>
        </div>
        <?php if (!empty($imagens)): ?>
            <div id="owl-galeria" class="owl-carousel">
                <?php foreach ($imagens as $k=>$im) { ?>
                    <a href="<?php echo IMAGENS.$im['pasta']."/".$im['src'];?>" data-fancybox="galeria">
                        <img alt="<?php echo $im['legenda']; ?>" title="<?php echo $im['legenda']; ?>" data-src="<?php echo IMAGENS.$im['pasta']."/".$im['src'];?>" class="owl-lazy" />
                    </a>
                <?php } ?>
            </div>
            <div class="espaco-menor"></div>
        <?php endif ?>
        <div class="conteudo-produto">
            <div class="row">
                <div class="col-md-8 anime">
                    <?php if (!empty($produto['descricao'])): ?>
                        <h3>Sobre o Imóvel</h3>
                        <?php echo imagemEditor($produto['descricao']); ?>
                    <?php endif ?>
                    <?php if (!empty($produto['conteudo'])): ?>
                        <div class="espaco-menor"></div>
                        <h3>Outras informações</h3>
                        <div class="tabela-informacoes">
                            <?php echo imagemEditor($produto['conteudo']); ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="col-md-4">
                    <div class="caracteristicas-imovel">
                        <h3>Características</h3>
                        <div class="row">
                            <div class="col-lg-6">
                                <?php if(!empty($produto['metragem'])): ?>
                                    <p><img src="templates/img/icone-metragem.png" alt="Metragem" title="Metragem"> <strong><?php echo $produto['metragem']; ?></strong> m²</p>
                                <?php endif; ?>
                                <?php if(!empty($produto['dormitorios'])): ?>
                                    <p><img src="templates/img/icone-dormitorios.png" alt="Dormitórios" title="Dormitórios"> <strong><?php echo $produto['dormitorios']; ?></strong> quarto(s)</p>
                                <?php endif; ?>
                                <?php if(!empty($produto['suites'])): ?>
                                    <p><img src="templates/img/icone-suites.png" alt="Dormitórios" title="Dormitórios"> <strong><?php echo $produto['suites']; ?></strong> suíte(s)</p>
                                <?php endif; ?>
                                <?php if(!empty($produto['vagas'])): ?>
                                    <p><img src="templates/img/icone-vagas.png" alt="Vagas" title="Vagas"> <strong><?php echo $produto['vagas']; ?></strong> vaga(s)</p>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-6 caracteristicas-direita">
                                <?php if (!empty($produto['valor'])): ?>
                                    <p>Venda</p>
                                    <span>R$ <?php echo $produto['valor']; ?></span>
                                    <?php if (!empty($produto['valor_metragem'])): ?>
                                        <small>R$ <?php echo number_format($produto['valor_metragem'], 2, ',', '.'); ?>/m²</small>
                                    <?php endif ?>
                                <?php endif ?>
                            </div>
                            <div class="col-lg-6">
                                <?php if(!empty($produto['condominio'])): ?>
                                    <div class="espaco-caracteristicas"></div>
                                    <p>Condomínio</p>
                                    <p><?php echo $produto['condominio']; ?></p>
                                <?php endif; ?>
                                <?php if(!empty($produto['iptu'])): ?>
                                    <div class="espaco-caracteristicas"></div>
                                    <p>IPTU</p>
                                    <p><?php echo $produto['iptu']; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="alinha-botao-imovel">
                        <button class="btn btn-primary btn-receber abre-contato">quero receber mais informações</a>
                    </div>
                    <?php if (!empty($produto['endereco'])): ?>
                        <div class="espaco-menor"></div>
<!--                         <?php 
                            $endereco = $produto['endereco'];
                            $codigoMapa = str_replace("\n", "+", $endereco);
                            $codigoMapa = str_replace(" ", "+", $codigoMapa);
                        ?> -->
                        <div class="mapa-contato">
                            <?php echo $produto['endereco']; ?>
                            <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3466.21806666488!2d-51.13013928450303!3d-29.684456782014713!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x951943afc4166151%3A0x4f70c28625e3a657!2s<?php echo $codigoMapa; ?>%2C+93510-365!5e0!3m2!1spt-BR!2sbr!4v1552957482417" width="360" height="240" class="w-100" frameborder="0" style="border:0" allowfullscreen></iframe> -->
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="espaco"></div>
        </div>
    </div>
    <?php if (!empty($produtos)): ?>
        <h2 class="texto-laranja text-center">Imóveis Relacionados</h2>
        <div class="alinha-cases">
            <div class="row">
                <?php foreach ($produtos as $produto): ?>
                    <div class="col-md-4">
                        <div class="case-individual imovel-individual">
                            <a href="<?php echo $produto['lin_nome']; ?>" class="caixa-imagem">
                                <?php if (!empty($produto['imagem'])): ?>
                                    <img data-src="<?php echo IMAGENS.'produtos/'.$produto['imagem']; ?>" alt="<?php echo $produto['titulo']; ?>" title="<?php echo $produto['titulo']; ?>" />
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
        <div class="espaco"></div>
    <?php endif; ?>
<?php } else { ?>
    <div class="topo-paginas">
        <div class="container text-center">
            <h1>Este conteúdo não está mais disponivel.</h1>
        </div>
    </div>
    <div class="espaco"></div>
<?php } ?>

<div class="modal fade" id="contato" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body text-center">
                <h3>Quero receber mais informações</h3>
                <form class="form" method="post" action="php/envia_email.php">
                    <input type="hidden" name="link" value="<?php echo $pag; ?>">
                    <input type="hidden" name="assunto" value="Quero receber mais informações sobre o imóvel: <?php echo $produto['titulo']; ?>">
                    <input type="text" name="nome" class="form-control" placeholder="Nome*" />
                    <input type="text" name="email" class="form-control" placeholder="E-mail*" />
                    <textarea name="mensagem" class="form-control mb-4" rows="3" placeholder="Mensagem"></textarea>
                    <div id="retorno" class="text-danger"></div>
                    <button class="btn btn-primary">Enviar Mensagem</button>
                </form>
            </div>
        </div>
    </div>
</div>