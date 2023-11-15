<div class="alinha-titulo-sombra sombra-topo-pagina">
    <div class="titulo-sombra">Contato</div>
</div>
<div class="container">
    <div class="row align-items-end">
        <div class="col-md-6">
            <div class="contato-esquerda">
                <?php if(!empty($imagem)) { ?>
                    <img src="<?php echo IMAGENS.'paginas/'.$imagem; ?>" alt="<?php echo $titulo; ?>" title="<?php echo $titulo; ?>" />
                <?php } ?>
                <div class="informacoes-contato">
                    <h3>Endereço</h3>
                    <?php if (!empty($config['endereco'])): ?>
                        <p class="endereco-contato"><i class="fas fa-map-marker-alt"></i> <?php echo nl2br($config['endereco']); ?></p>
                    <?php endif; ?>
                    <h3>Contato</h3>
                    <?php if (!empty($config['fone1'])): ?>
                        <a href="tel:<?php echo $config['fone1']; ?>" target="_blank" class="telefone-rodape"><i class="fas fa-phone"></i> <?php echo $config['fone1'] ?></a>
                    <?php endif; ?>
                    <a class="email-rodape" href="mailto:<?php echo $config['emailC']; ?>"><i class="fas fa-envelope"></i> <?php echo $config['emailC']; ?></a>
                    <h3>Siga-nos</h3>
                    <div class="redes-sociais-contato">
                        <?php if($config['rede1']) { ?>
                            <a href="<?php echo $config['rede1']; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <?php } ?>
                        <?php if($config['rede2']) { ?>
                            <a href="<?php echo $config['rede2']; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <?php } ?>
                        <?php if($config['rede3']) { ?>
                            <a href="<?php echo $config['rede3']; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        <?php } ?>
                        <?php if($config['rede4']) { ?>
                            <a href="<?php echo $config['rede4']; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                        <?php } ?>
                        <?php if($config['rede5']) { ?>
                            <a href="<?php echo $config['rede5']; ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                        <?php } ?>
                        <?php if($config['rede6']) { ?>
                            <a href="<?php echo $config['rede6']; ?>" target="_blank"><i class="fab fa-pinterest"></i></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 contato-direita">
            <h2 class="texto-azul"><?php echo $titulo; ?></h2>
            <?php echo $conteudo; ?>
            <form class="form" method="post" action="php/envia_email.php">
                <input type="hidden" name="link" value="<?php echo $pag; ?>">
                <input type="text" name="nome" class="form-control" placeholder="Nome*" />
                <input type="text" name="email" class="form-control" placeholder="E-mail*" />
                <select name="assunto" class="custom-select">
                    <option value="">Assunto</option>
                    <option value="Quero vender">Quero vender</option>
                    <option value="Quero comprar">Quero comprar</option>
                    <option value="Quero ser um parceiro">Quero ser um parceiro</option>
                    <option value="Trabalhe conosco">Trabalhe conosco</option>
                    <option value="Outros">Outros</option>
                </select>
                <textarea name="mensagem" class="form-control" rows="3" placeholder="Mensagem"></textarea>
                <div id="retorno" class="text-danger"></div>
                <button class="btn btn-primary">Enviar Mensagem</button>
            </form>
        </div>
    </div>
</div>
<div class="espaco"></div>